/**
 * analyzer.js — orchestrates a full Nonelab analysis of one short-form video.
 *
 * Resolves the source (uploaded file OR url), attaches it to Gemini in the
 * right way, runs the structured analysis against the Nonelab schema, and
 * returns the validated result plus light, deterministic post-processing
 * (verdict re-derivation, calibration_gap recompute) so the numbers are
 * internally consistent regardless of model drift.
 */

'use strict';

const fs = require('fs');
const os = require('os');
const path = require('path');
const crypto = require('crypto');

const gemini = require('./gemini');
const knowledge = require('./nonelab-knowledge');

const MAX_DOWNLOAD_BYTES = 200 * 1024 * 1024; // 200 MB guard for remote files

/** Download a non-YouTube remote video to a temp file so it can be uploaded. */
async function downloadToTemp(url) {
  const res = await fetch(url, { redirect: 'follow' });
  if (!res.ok) throw new Error(`Could not fetch video URL (${res.status}).`);
  const mimeType = res.headers.get('content-type')?.split(';')[0] || 'video/mp4';
  if (!/^(video|application\/octet-stream)/.test(mimeType)) {
    throw new Error(`URL did not point to a video (got "${mimeType}"). For YouTube use the watch URL directly.`);
  }
  const buf = Buffer.from(await res.arrayBuffer());
  if (buf.length > MAX_DOWNLOAD_BYTES) throw new Error('Remote video exceeds the 200 MB limit.');
  const tmp = path.join(os.tmpdir(), `nonelab-${crypto.randomBytes(6).toString('hex')}`);
  fs.writeFileSync(tmp, buf);
  return { filePath: tmp, mimeType, cleanup: () => fs.promises.unlink(tmp).catch(() => {}) };
}

/** Clamp a numeric score into 0-100 ints; tolerate model noise. */
function clampScore(n) {
  const v = Math.round(Number(n));
  if (!Number.isFinite(v)) return 0;
  return Math.max(0, Math.min(100, v));
}

/** Re-derive verdict from the calibrated score so the ladder is authoritative. */
function verdictFor(score) {
  if (score >= knowledge.VERDICTS.SHIP.min) return 'SHIP';
  if (score >= knowledge.VERDICTS.REWORK.min) return 'REWORK';
  return 'NO-GO';
}

/** Light post-processing: keep the model's judgement, enforce arithmetic. */
function normalize(analysis) {
  const vp = analysis.virality_prediction;
  if (vp) {
    vp.optimistic_score = clampScore(vp.optimistic_score);
    vp.virality_score = clampScore(vp.virality_score);
    vp.calibration_gap = vp.optimistic_score - vp.virality_score;
    vp.verdict = verdictFor(vp.virality_score);
  }
  if (analysis.hook) {
    analysis.hook.score = clampScore(analysis.hook.score);
    analysis.hook.percentile = clampScore(analysis.hook.percentile);
  }
  const dna = analysis.viral_dna;
  if (dna) {
    for (const k of ['viral_dna_score', 'replicability_score', 'originality_score', 'consistency_score', 'audience_fatigue']) {
      dna[k] = clampScore(dna[k]);
    }
  }
  return analysis;
}

/**
 * @param {Object} opts
 * @param {string} [opts.url]        Public video URL (YouTube or direct video file).
 * @param {Object} [opts.file]       Multer file: { path, mimetype, originalname }.
 * @param {string} [opts.niche]      Niche hint.
 * @param {string} [opts.platform]   tiktok | reels | shorts.
 * @param {string} [opts.model]      Gemini model override.
 */
async function analyzeVideo(opts = {}) {
  const { url, file, niche, platform, model } = opts;
  if (!url && !file) throw new Error('Provide either a video URL or an uploaded file.');

  const systemInstruction = knowledge.buildSystemInstruction();
  const responseSchema = knowledge.analysisResponseSchema();

  let videoPart;
  let sourceLabel;
  const cleanups = [];

  try {
    if (url && gemini.isYouTubeUrl(url)) {
      videoPart = gemini.youtubeVideoPart(url);
      sourceLabel = 'YouTube URL';
    } else if (url) {
      const dl = await downloadToTemp(url);
      cleanups.push(dl.cleanup);
      const uploaded = await gemini.uploadFile({ filePath: dl.filePath, mimeType: dl.mimeType, displayName: 'nonelab-url' });
      videoPart = gemini.uploadedVideoPart(uploaded);
      sourceLabel = 'remote video file';
    } else {
      const uploaded = await gemini.uploadFile({
        filePath: file.path,
        mimeType: file.mimetype || 'video/mp4',
        displayName: file.originalname || 'nonelab-upload',
      });
      videoPart = gemini.uploadedVideoPart(uploaded);
      sourceLabel = 'uploaded file';
    }

    const userPrompt = knowledge.buildUserPrompt({ niche, platform, sourceLabel });
    const { analysis, model: usedModel, usage } = await gemini.generateAnalysis({
      model,
      systemInstruction,
      userPrompt,
      videoPart,
      responseSchema,
    });

    return {
      ok: true,
      source: { type: file ? 'file' : 'url', label: sourceLabel, name: file?.originalname || url },
      model: usedModel,
      usage,
      analysis: normalize(analysis),
      generated_at: new Date().toISOString(),
    };
  } finally {
    await Promise.all(cleanups.map((fn) => fn()));
  }
}

module.exports = { analyzeVideo };
