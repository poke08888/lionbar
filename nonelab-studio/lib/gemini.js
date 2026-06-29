/**
 * gemini.js — minimal, dependency-free client for the Google Gemini API.
 *
 * Uses the native `fetch` in Node 18+. Honors the outbound HTTPS proxy that
 * the runtime sets via HTTPS_PROXY (Node respects it automatically for fetch
 * when undici picks up the env, but we also support GEMINI_API_BASE override).
 *
 * Two video paths are supported:
 *   - A public video URL (YouTube is natively understood by Gemini via
 *     fileData.fileUri; other URLs are downloaded and uploaded to the Files API).
 *   - A local uploaded file -> Files API (resumable upload) -> generateContent.
 */

'use strict';

const fs = require('fs');

const API_BASE = process.env.GEMINI_API_BASE || 'https://generativelanguage.googleapis.com';
const DEFAULT_MODEL = process.env.GEMINI_MODEL || 'gemini-2.5-flash';

function apiKey() {
  const key = process.env.GEMINI_API_KEY || process.env.GOOGLE_API_KEY;
  if (!key) {
    const err = new Error('GEMINI_API_KEY is not set. Add it to your environment or .env file.');
    err.code = 'NO_API_KEY';
    throw err;
  }
  return key;
}

function isYouTubeUrl(url) {
  return /^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\//i.test(url);
}

async function readJson(res) {
  const text = await res.text();
  try {
    return JSON.parse(text);
  } catch {
    return { _raw: text };
  }
}

/**
 * Upload bytes to the Gemini Files API using the resumable protocol, then poll
 * until the file is ACTIVE (video processing is async).
 * @returns {Promise<{uri:string, mimeType:string, name:string}>}
 */
async function uploadFile({ filePath, mimeType, displayName }) {
  const key = apiKey();
  const numBytes = fs.statSync(filePath).size;

  // 1. Start a resumable upload session.
  const startRes = await fetch(`${API_BASE}/upload/v1beta/files?key=${key}`, {
    method: 'POST',
    headers: {
      'X-Goog-Upload-Protocol': 'resumable',
      'X-Goog-Upload-Command': 'start',
      'X-Goog-Upload-Header-Content-Length': String(numBytes),
      'X-Goog-Upload-Header-Content-Type': mimeType,
      'Content-Type': 'application/json',
    },
    body: JSON.stringify({ file: { display_name: displayName || 'nonelab-upload' } }),
  });
  if (!startRes.ok) {
    throw new Error(`Files API start failed (${startRes.status}): ${(await readJson(startRes))._raw || ''}`);
  }
  const uploadUrl = startRes.headers.get('x-goog-upload-url');
  if (!uploadUrl) throw new Error('Files API did not return an upload URL.');

  // 2. Upload the bytes and finalize.
  const bytes = fs.readFileSync(filePath);
  const uploadRes = await fetch(uploadUrl, {
    method: 'POST',
    headers: {
      'Content-Length': String(numBytes),
      'X-Goog-Upload-Offset': '0',
      'X-Goog-Upload-Command': 'upload, finalize',
    },
    body: bytes,
  });
  if (!uploadRes.ok) {
    throw new Error(`Files API upload failed (${uploadRes.status}): ${(await readJson(uploadRes))._raw || ''}`);
  }
  let fileObj = (await readJson(uploadRes)).file;
  if (!fileObj || !fileObj.name) throw new Error('Files API upload returned no file object.');

  // 3. Poll until the video finishes processing (ACTIVE) or fails.
  const deadline = Date.now() + 1000 * 60 * 5; // 5 min ceiling
  while (fileObj.state === 'PROCESSING') {
    if (Date.now() > deadline) throw new Error('Gemini took too long to process the video (>5 min).');
    await new Promise((r) => setTimeout(r, 3000));
    const pollRes = await fetch(`${API_BASE}/v1beta/${fileObj.name}?key=${key}`);
    if (!pollRes.ok) throw new Error(`Files API poll failed (${pollRes.status}).`);
    fileObj = await readJson(pollRes);
  }
  if (fileObj.state === 'FAILED') throw new Error('Gemini failed to process the uploaded video.');

  return { uri: fileObj.uri, mimeType: fileObj.mimeType || mimeType, name: fileObj.name };
}

/**
 * Run a structured analysis. `videoPart` is the Gemini content part referencing
 * the video (either {fileData:{fileUri}} for YouTube or an uploaded file).
 */
async function generateAnalysis({ model, systemInstruction, userPrompt, videoPart, responseSchema }) {
  const key = apiKey();
  const useModel = model || DEFAULT_MODEL;

  const body = {
    systemInstruction: { parts: [{ text: systemInstruction }] },
    contents: [{ role: 'user', parts: [{ text: userPrompt }, videoPart] }],
    generationConfig: {
      temperature: 0.4,
      responseMimeType: 'application/json',
      responseSchema,
    },
  };

  const res = await fetch(`${API_BASE}/v1beta/models/${useModel}:generateContent?key=${key}`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(body),
  });

  const json = await readJson(res);
  if (!res.ok) {
    const msg = json.error?.message || json._raw || `HTTP ${res.status}`;
    const err = new Error(`Gemini generateContent failed: ${msg}`);
    err.status = res.status;
    throw err;
  }

  const candidate = json.candidates?.[0];
  const text = candidate?.content?.parts?.map((p) => p.text).filter(Boolean).join('') || '';
  if (!text) {
    const blockReason = json.promptFeedback?.blockReason;
    throw new Error(blockReason ? `Gemini returned no content (blocked: ${blockReason}).` : 'Gemini returned an empty response.');
  }

  let parsed;
  try {
    parsed = JSON.parse(text);
  } catch {
    throw new Error('Gemini returned non-JSON despite the schema constraint.');
  }
  return { analysis: parsed, model: useModel, usage: json.usageMetadata || null };
}

/** Build the Gemini content part for a YouTube URL (native understanding). */
function youtubeVideoPart(url) {
  return { fileData: { fileUri: url } };
}

/** Build the Gemini content part for an uploaded/processed file. */
function uploadedVideoPart({ uri, mimeType }) {
  return { fileData: { fileUri: uri, mimeType } };
}

module.exports = {
  DEFAULT_MODEL,
  isYouTubeUrl,
  uploadFile,
  generateAnalysis,
  youtubeVideoPart,
  uploadedVideoPart,
  apiKey,
};
