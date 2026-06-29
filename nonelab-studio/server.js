/**
 * server.js — Nonelab Studio backend.
 *
 * Serves the Studio UI and exposes the analysis API. Keeps the surface tiny:
 *   GET  /api/health   -> readiness + whether a Gemini key is configured
 *   GET  /api/meta     -> niches/platforms/framework metadata for the UI
 *   POST /api/analyze  -> run a full Nonelab analysis (url or multipart file)
 */

'use strict';

require('dotenv').config();

const path = require('path');
const fs = require('fs');
const os = require('os');
const express = require('express');
const multer = require('multer');

const knowledge = require('./lib/nonelab-knowledge');
const { analyzeVideo } = require('./lib/analyzer');
const { DEFAULT_MODEL } = require('./lib/gemini');

const app = express();
const PORT = process.env.PORT || 3000;

app.use(express.json({ limit: '2mb' }));
app.use(express.static(path.join(__dirname, 'public')));

const upload = multer({
  dest: path.join(os.tmpdir(), 'nonelab-uploads'),
  limits: { fileSize: 200 * 1024 * 1024 }, // 200 MB
  fileFilter: (_req, file, cb) => {
    if (/^video\//.test(file.mimetype)) return cb(null, true);
    cb(new Error('Only video files are accepted.'));
  },
});

app.get('/api/health', (_req, res) => {
  res.json({
    ok: true,
    service: 'nonelab-studio',
    model: DEFAULT_MODEL,
    gemini_key_configured: Boolean(process.env.GEMINI_API_KEY || process.env.GOOGLE_API_KEY),
  });
});

app.get('/api/meta', (_req, res) => {
  res.json({
    niches: knowledge.NICHES,
    platforms: knowledge.PLATFORMS,
    hook_signals: knowledge.HOOK_SIGNALS.map((s) => ({ name: s.name, probe: s.probe })),
    viral_dna: knowledge.VIRAL_DNA_DIMENSIONS.map((d) => ({ name: d.name, inverted: d.inverted, probe: d.probe })),
    attack_vectors: knowledge.ATTACK_VECTORS.map((v) => ({ name: v.name, severity: v.severity })),
    calibration_anchors: knowledge.HOOK_CALIBRATION_ANCHORS,
    model: DEFAULT_MODEL,
  });
});

app.post('/api/analyze', upload.single('video'), async (req, res) => {
  const file = req.file;
  try {
    const url = (req.body.url || '').trim();
    const niche = (req.body.niche || '').trim();
    const platform = (req.body.platform || '').trim();
    const model = (req.body.model || '').trim() || undefined;

    if (!url && !file) {
      return res.status(400).json({ ok: false, error: 'Provide a video URL or upload a video file.' });
    }

    const result = await analyzeVideo({ url: url || undefined, file, niche, platform, model });
    res.json(result);
  } catch (err) {
    const code = err.code === 'NO_API_KEY' ? 503 : err.status || 500;
    res.status(code).json({ ok: false, error: err.message, code: err.code });
  } finally {
    if (file?.path) fs.promises.unlink(file.path).catch(() => {});
  }
});

// Multer / generic error funnel.
app.use((err, _req, res, _next) => {
  res.status(400).json({ ok: false, error: err.message });
});

app.listen(PORT, () => {
  // eslint-disable-next-line no-console
  console.log(`Nonelab Studio running on http://localhost:${PORT}  (model: ${DEFAULT_MODEL})`);
});

module.exports = app;
