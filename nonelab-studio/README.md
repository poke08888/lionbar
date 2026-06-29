# Nonelab Studio — Viral Video Analysis

Gemini-powered short-form video analysis built on the **Nonelab video** framework.
Drop a TikTok / Reel / YouTube Short and the engine watches it end-to-end, then
grades it the way the Nonelab / Hook Layer toolset does — only the evidence comes
from the **video itself** (what Gemini sees and hears), not a scraped corpus.

> **Note on the design file:** the design link
> (`https://claude.ai/design/p/740213d3-…?file=Nonelab+Studio.dc.html`) could not be
> imported in this build environment — the Claude Design MCP needs an interactive
> `/design-login`, which isn't available in a non-interactive web session. The UI
> here is a faithful "Nonelab Studio" interpretation (dark studio console, token-
> driven). To realign it pixel-for-pixel, use Claude Design's **"Send to Claude
> Code Web"** to seed `Nonelab Studio.dc.html` into the workspace, then the
> tokens at the top of [`public/styles.css`](public/styles.css) can be swapped to
> match — see [Matching the design](#matching-the-design).

## What it measures

The seven capabilities of the Nonelab video skill, codified in
[`lib/nonelab-knowledge.js`](lib/nonelab-knowledge.js):

| Capability | What it returns |
|---|---|
| **Hook score** | 0–100 with six evidence-backed signals, a calibration anchor (10/30/50/70/85/95), `would_fail_because`, and 3 rewrites |
| **Viral DNA** | viral-DNA, replicability, originality, consistency, audience-fatigue (inverted), each grounded in the video |
| **Adversarial virality** | optimistic vs. calibrated score, the calibration gap, attack vectors (present/mitigated), and a SHIP / REWORK / NO-GO verdict |
| **Template match** | closest proven template: hook pattern + portable format structure |
| **Voice DNA** | energy/humor/vocabulary/pacing + reproducible metrics (TTR, filler rate, sentence length, signature phrases) |
| **Trend fit** | rising formats the video rides + saturated patterns to retire |
| **Recommendations** | ranked, concrete do-this-next actions |

Detection runs across the 17 canonical Nonelab niches. Every score carries a
**verbatim evidence string** from the video, and the analysis self-reports its
own quality (`full` / `partial` / `degraded`) so missing audio or unreadable
footage is flagged, never silently fabricated around.

## Architecture

```
nonelab-studio/
├── server.js                  Express app: static UI + /api/{health,meta,analyze}
├── lib/
│   ├── nonelab-knowledge.js   The Nonelab framework: rubrics, anchors, vectors,
│   │                          the Gemini system instruction + response schema
│   ├── gemini.js              Dependency-free Gemini client (Files API + generate)
│   └── analyzer.js            Orchestrates source → Gemini → normalized result
└── public/                    index.html · styles.css · app.js  (no build step)
```

The flow: the browser posts a URL or file to `/api/analyze` → `analyzer.js`
attaches it to Gemini (YouTube URLs natively; uploads/other URLs via the Gemini
**Files API**) → `gemini.js` calls `generateContent` with the Nonelab system
instruction and a strict JSON `responseSchema` → the result is normalized
(verdict ladder + calibration arithmetic re-derived server-side) and rendered.

## Setup

Requires **Node.js 18.17+** (uses the built-in `fetch`).

```bash
cd nonelab-studio
npm install
cp .env.example .env        # then paste your GEMINI_API_KEY
npm start                   # http://localhost:3000
```

Get a key at <https://aistudio.google.com/apikey>. Without a key the UI loads and
shows a "no Gemini key" badge; analysis returns a 503 until the key is set.

## Configuration

| Var | Default | Purpose |
|---|---|---|
| `GEMINI_API_KEY` | — | **Required.** Google Gemini API key |
| `GEMINI_MODEL` | `gemini-2.5-flash` | Any video-capable Gemini model (`gemini-2.5-pro` for deeper analysis) |
| `PORT` | `3000` | Server port |
| `GEMINI_API_BASE` | Google endpoint | Override the API base if needed |

## API

- `GET /api/health` → `{ ok, model, gemini_key_configured }`
- `GET /api/meta` → niches, platforms, signals, anchors (drives the UI)
- `POST /api/analyze` → multipart (`video` file) **or** form field `url`, plus
  optional `niche`, `platform`, `model`. Returns the full normalized analysis.

```bash
curl -X POST http://localhost:3000/api/analyze \
  -F 'url=https://www.youtube.com/watch?v=XXXXXXXXXXX' \
  -F 'platform=shorts'
```

### Sources
- **YouTube** — paste the watch URL; Gemini reads it natively.
- **Upload** — drag any `video/*` file (≤200 MB); it's sent to the Gemini Files
  API, processed, then analyzed.
- **Direct video URL** — a `.mp4`/`video/*` link is downloaded then uploaded.
  (TikTok/Reels page URLs aren't direct video files — upload the file for those.)

## Matching the design

Once `Nonelab Studio.dc.html` is available, the visual system is token-driven:
edit the `:root` block at the top of [`public/styles.css`](public/styles.css)
(`--accent`, `--bg`, `--panel`, fonts, radii) to match the design's tokens. The
layout regions (top bar, hero, input panel, result cards) map 1:1 to typical
"studio" design sections, so most alignment needs no structural changes.
