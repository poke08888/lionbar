/**
 * nonelab-knowledge.js
 * ---------------------------------------------------------------------------
 * The full knowledge base of the "Nonelab video" skill, codified so the
 * backend can run the same viral short-form analysis that the Nonelab/Hook
 * Layer toolset performs — driven by Gemini's video understanding instead of
 * a scraping pipeline.
 *
 * It encodes, faithfully, the seven capabilities of the skill:
 *   1. analyze_account    -> Viral DNA scoring
 *   2. score_hook         -> Hook scoring with calibration anchors
 *   3. predict_virality   -> Adversarial (optimistic vs. calibrated) scoring
 *   4. find_viral_template-> Niche template matching
 *   5. match_voice        -> Voice DNA + deterministic voice metrics
 *   6. trend_pulse        -> Trend alignment / saturation
 *   7. search_videos      -> Corpus framing for comparable discovery
 *
 * Nothing here calls an external corpus; the analysis is grounded in the
 * *video itself* (what Gemini sees + hears) measured against these rubrics.
 */

'use strict';

/** The 17 canonical niches the Nonelab framework operates over. */
const NICHES = [
  'Beauty & Skincare',
  'Fitness & Health',
  'Food & Cooking',
  'Fashion & Style',
  'Tech & Gadgets',
  'Finance & Business',
  'Education & Learning',
  'Travel & Adventure',
  'Comedy & Entertainment',
  'Gaming',
  'Lifestyle & Wellness',
  'Parenting & Family',
  'DIY & Crafts',
  'Music & Dance',
  'Pets & Animals',
  'Sports',
  'Motivation & Self-Help',
  'SaaS & AI Tools',
];

const PLATFORMS = ['tiktok', 'reels', 'shorts'];

/**
 * Calibration anchors for hook scoring. The skill grades every hook against
 * the closest of these six reference points and names it in the verdict.
 */
const HOOK_CALIBRATION_ANCHORS = [
  { score: 10, label: 'Dead on arrival — no tension, no specificity, scroll-past in <1s.' },
  { score: 30, label: 'Generic — a pattern the viewer has seen a thousand times, zero curiosity gap.' },
  { score: 50, label: 'Competent but safe — clear, but nothing forces the next second to be watched.' },
  { score: 70, label: 'Strong — a real curiosity gap or stakes; would survive a busy feed.' },
  { score: 85, label: 'Elite — visceral tension + specificity; near-impossible to scroll past.' },
  { score: 95, label: 'Generational — reframes expectation in the first beat; built-in share trigger.' },
];

/**
 * The six hook sub-signals. Every hook score must be decomposed into exactly
 * these, each with a 0-100 sub-score AND a verbatim evidence string drawn from
 * the actual opening of the video.
 */
const HOOK_SIGNALS = [
  {
    key: 'curiosity_gap',
    name: 'Curiosity gap',
    probe: 'Does the opening open a loop the brain needs closed? Is there a question the viewer cannot answer yet?',
  },
  {
    key: 'specificity',
    name: 'Specificity',
    probe: 'Concrete numbers, names, nouns vs. vague abstractions. Specific beats clever.',
  },
  {
    key: 'stakes_tension',
    name: 'Stakes / tension',
    probe: 'Is something at risk, surprising, or emotionally charged in the first 1-2 seconds?',
  },
  {
    key: 'pattern_interrupt',
    name: 'Pattern interrupt',
    probe: 'Visual or verbal break from the expected feed — unexpected framing, motion, or claim.',
  },
  {
    key: 'relevance_targeting',
    name: 'Relevance / targeting',
    probe: 'Does it call out a specific person/identity ("if you...") so the right viewer self-selects?',
  },
  {
    key: 'clarity_speed',
    name: 'Clarity & speed',
    probe: 'Is the value legible inside 2 seconds with no wasted ramp-up or throat-clearing?',
  },
];

/**
 * Viral DNA dimensions (from analyze_account). Each scored 0-100 and backed
 * by evidence. audience_fatigue is INVERTED: high = bad (overused formula).
 */
const VIRAL_DNA_DIMENSIONS = [
  {
    key: 'viral_dna_score',
    name: 'Viral DNA',
    probe: 'Overall density of proven viral mechanics: hook, pacing, payoff, loop, share-trigger.',
    inverted: false,
  },
  {
    key: 'replicability_score',
    name: 'Replicability',
    probe: 'Could a creator copy this format and reasonably expect a similar result? Is the structure a portable template?',
    inverted: false,
  },
  {
    key: 'originality_score',
    name: 'Originality',
    probe: 'How far from the saturated baseline is the idea/execution? Fresh angle vs. recycled trend.',
    inverted: false,
  },
  {
    key: 'consistency_score',
    name: 'Consistency',
    probe: 'Does the video deliver a single coherent promise from hook to payoff without drifting?',
    inverted: false,
  },
  {
    key: 'audience_fatigue',
    name: 'Audience fatigue',
    probe: 'How worn-out is this format/sound/trend? HIGH = audience is tired of it (a risk, not a strength).',
    inverted: true,
  },
];

/**
 * Adversarial attack vectors (from predict_virality). The calibrated pass
 * checks each; a vector is "present" (un-mitigated, drags the score) or
 * "mitigated" (the script defuses it). This is what separates an honest score
 * from an optimistic self-grade.
 */
const ATTACK_VECTORS = [
  { key: 'slow_hook', name: 'Slow hook', severity: 'high', probe: 'First 2s waste time on intros, logos, or ramp-up.' },
  { key: 'no_payoff', name: 'Missing payoff', severity: 'high', probe: 'The hook promises something the body never delivers.' },
  { key: 'generic_format', name: 'Generic format', severity: 'medium', probe: 'Indistinguishable from a thousand other videos; no signature.' },
  { key: 'ai_slop', name: 'AI slop / hollow polish', severity: 'high', probe: 'Smooth but says nothing — buzzwords, no concrete substance or POV.' },
  { key: 'no_share_trigger', name: 'No share trigger', severity: 'medium', probe: 'Nothing that makes a viewer DM it to a friend or stitch it.' },
  { key: 'weak_loop', name: 'Weak loop / no rewatch', severity: 'medium', probe: 'Ends flat; no reason to rewatch or finish, hurting completion.' },
  { key: 'pacing_drag', name: 'Pacing drag', severity: 'medium', probe: 'Dead air, long sentences, or a saggy middle that bleeds retention.' },
  { key: 'unclear_cta', name: 'Unclear takeaway/CTA', severity: 'low', probe: 'Viewer finishes unsure what to do, feel, or remember.' },
  { key: 'audio_mismatch', name: 'Audio / trend mismatch', severity: 'low', probe: 'Sound, captions, or trend usage fights the message instead of amplifying it.' },
];

/**
 * Verdict ladder for predict_virality. The calibrated (adversarial) score maps
 * to one of these, NEVER the optimistic self-grade.
 */
const VERDICTS = {
  SHIP: { min: 72, reason: 'Strong viral mechanics with few un-mitigated attack vectors — publish.' },
  REWORK: { min: 45, reason: 'A real idea undercut by fixable weaknesses — patch the present vectors first.' },
  'NO-GO': { min: 0, reason: 'Core mechanics are missing; a tweak will not save it — rebuild from the hook.' },
};

/**
 * Voice DNA model (from match_voice). The qualitative profile plus the
 * deterministic, reproducible voice_metrics that the skill insists on
 * surfacing as numbers, not vibes.
 */
const VOICE_PROFILE_FIELDS = ['energy', 'humor', 'vocabulary', 'pacing', 'signature_moves'];
const VOICE_METRICS_FIELDS = [
  { key: 'vocab_diversity_ttr', name: 'Vocab diversity (TTR)', note: 'Type-token ratio of the transcript, 0-1.' },
  { key: 'filler_rate_per_100_words', name: 'Filler rate / 100 words', note: 'um, like, you know, basically, etc.' },
  { key: 'avg_sentence_length_words', name: 'Avg sentence length (words)', note: 'Spoken-cadence proxy.' },
  { key: 'total_words', name: 'Total words', note: 'Transcript length.' },
  { key: 'signature_phrases', name: 'Signature phrases', note: 'Top recurring 2-3-grams with counts.' },
];

/**
 * Quality contract mirrored from every Hook Layer tool: the analysis must
 * self-report its own confidence so the UI can flag partial/degraded results
 * (e.g. no audio track => no voice metrics).
 */
const QUALITY_LEVELS = ['full', 'partial', 'degraded'];

/**
 * The JSON schema Gemini is forced to fill. A subset of OpenAPI 3 (the dialect
 * the Gemini API accepts for responseSchema).
 */
function analysisResponseSchema() {
  const scoreInt = { type: 'integer', minimum: 0, maximum: 100 };
  const signalArray = {
    type: 'array',
    items: {
      type: 'object',
      properties: {
        name: { type: 'string' },
        score: scoreInt,
        evidence: { type: 'string', description: 'Verbatim moment/quote from the video that justifies the sub-score.' },
      },
      required: ['name', 'score', 'evidence'],
    },
  };

  return {
    type: 'object',
    properties: {
      quality: {
        type: 'object',
        properties: {
          level: { type: 'string', enum: QUALITY_LEVELS },
          reason: { type: 'string' },
        },
        required: ['level', 'reason'],
      },
      summary: { type: 'string', description: '2-3 sentence plain-language read of the video and its viral thesis.' },
      detected_niche: { type: 'string', enum: NICHES },
      format_fingerprint: {
        type: 'string',
        description: 'The portable structure, e.g. "POV cold-open -> problem -> 3-step payoff -> loop-back".',
      },
      transcript_excerpt: { type: 'string', description: 'The first ~2 seconds of spoken/on-screen words, verbatim. Empty if no audio/text.' },

      hook: {
        type: 'object',
        properties: {
          opening_text: { type: 'string', description: 'The verbatim hook (first 1-2s of words/on-screen text).' },
          score: scoreInt,
          percentile: scoreInt,
          calibration_anchor: { type: 'string', description: 'Closest anchor from 10/30/50/70/85/95 with its one-line reason.' },
          matched_pattern: { type: 'string', description: 'The named viral hook pattern it most resembles.' },
          signals: signalArray,
          would_fail_because: { type: 'string', description: 'The single most likely reason this hook gets scrolled past.' },
          rewrites: {
            type: 'array',
            description: 'Exactly three higher-quality rewrites of the hook.',
            items: { type: 'string' },
          },
        },
        required: ['opening_text', 'score', 'percentile', 'calibration_anchor', 'matched_pattern', 'signals', 'would_fail_because', 'rewrites'],
      },

      viral_dna: {
        type: 'object',
        properties: {
          viral_dna_score: scoreInt,
          replicability_score: scoreInt,
          originality_score: scoreInt,
          consistency_score: scoreInt,
          audience_fatigue: scoreInt,
          signals: signalArray,
          would_fail_because: { type: 'string' },
        },
        required: ['viral_dna_score', 'replicability_score', 'originality_score', 'consistency_score', 'audience_fatigue', 'signals', 'would_fail_because'],
      },

      virality_prediction: {
        type: 'object',
        properties: {
          optimistic_score: scoreInt,
          virality_score: scoreInt,
          calibration_gap: { type: 'integer', description: 'optimistic_score - virality_score. The honesty delta.' },
          score_range: { type: 'string', description: 'e.g. "38-52".' },
          verdict: { type: 'string', enum: Object.keys(VERDICTS) },
          reason: { type: 'string' },
          attack_vectors: {
            type: 'array',
            items: {
              type: 'object',
              properties: {
                name: { type: 'string' },
                status: { type: 'string', enum: ['present', 'mitigated'] },
                severity: { type: 'string', enum: ['low', 'medium', 'high'] },
                note: { type: 'string', description: 'Why present, or how the video mitigates it.' },
              },
              required: ['name', 'status', 'severity', 'note'],
            },
          },
        },
        required: ['optimistic_score', 'virality_score', 'calibration_gap', 'score_range', 'verdict', 'reason', 'attack_vectors'],
      },

      template_match: {
        type: 'object',
        properties: {
          name: { type: 'string', description: 'Named proven template, e.g. "The Contrarian Cold-Open".' },
          hook_pattern: { type: 'string' },
          format_structure: { type: 'string' },
          why_it_fits: { type: 'string' },
          avg_views_band: { type: 'string', description: 'Rough performance band this template tends to land in.' },
        },
        required: ['name', 'hook_pattern', 'format_structure', 'why_it_fits'],
      },

      voice: {
        type: 'object',
        properties: {
          energy: { type: 'string' },
          humor: { type: 'string' },
          vocabulary: { type: 'string' },
          pacing: { type: 'string' },
          signature_moves: { type: 'array', items: { type: 'string' } },
          metrics: {
            type: 'object',
            properties: {
              vocab_diversity_ttr: { type: 'number' },
              filler_rate_per_100_words: { type: 'number' },
              avg_sentence_length_words: { type: 'number' },
              total_words: { type: 'integer' },
              signature_phrases: {
                type: 'array',
                items: {
                  type: 'object',
                  properties: { phrase: { type: 'string' }, count: { type: 'integer' } },
                  required: ['phrase', 'count'],
                },
              },
            },
            required: ['vocab_diversity_ttr', 'filler_rate_per_100_words', 'avg_sentence_length_words', 'total_words', 'signature_phrases'],
          },
        },
        required: ['energy', 'humor', 'vocabulary', 'pacing', 'signature_moves', 'metrics'],
      },

      trends: {
        type: 'object',
        properties: {
          aligned: {
            type: 'array',
            description: 'Currently-rising formats/topics this video is riding.',
            items: {
              type: 'object',
              properties: {
                label: { type: 'string' },
                growth_label: { type: 'string', enum: ['Early signal', 'Rising', 'Accelerating', 'Peaking'] },
                note: { type: 'string' },
              },
              required: ['label', 'growth_label', 'note'],
            },
          },
          saturated: {
            type: 'array',
            description: 'Worn-out patterns the video leans on that should be retired.',
            items: { type: 'string' },
          },
        },
        required: ['aligned', 'saturated'],
      },

      recommendations: {
        type: 'array',
        description: 'Ranked, concrete, do-this-next actions. Most impactful first.',
        items: {
          type: 'object',
          properties: {
            priority: { type: 'string', enum: ['high', 'medium', 'low'] },
            action: { type: 'string' },
            rationale: { type: 'string' },
          },
          required: ['priority', 'action', 'rationale'],
        },
      },
    },
    required: [
      'quality', 'summary', 'detected_niche', 'format_fingerprint', 'transcript_excerpt',
      'hook', 'viral_dna', 'virality_prediction', 'template_match', 'voice', 'trends', 'recommendations',
    ],
  };
}

/** Build the system instruction that turns Gemini into the Nonelab analyst. */
function buildSystemInstruction() {
  const anchors = HOOK_CALIBRATION_ANCHORS.map((a) => `  - ${a.score}: ${a.label}`).join('\n');
  const hookSignals = HOOK_SIGNALS.map((s) => `  - ${s.name}: ${s.probe}`).join('\n');
  const dna = VIRAL_DNA_DIMENSIONS.map((d) => `  - ${d.name}${d.inverted ? ' (INVERTED — high is bad)' : ''}: ${d.probe}`).join('\n');
  const vectors = ATTACK_VECTORS.map((v) => `  - ${v.name} [${v.severity}]: ${v.probe}`).join('\n');

  return `You are the Nonelab Studio analyst — the engine behind the "Nonelab video" skill, a short-form (TikTok / Reels / YouTube Shorts) viral-intelligence system. You watch a single video and grade it with the discipline of a creator who has reverse-engineered thousands of viral posts. You are precise, evidence-bound, and adversarial: you never flatter a video.

NON-NEGOTIABLE PRINCIPLES
1. Ground every claim in the actual video. Quote the real opening words, name the real on-screen moments, cite real timestamps when useful. Never invent metadata, view counts, or growth percentages — you have no corpus, only the video itself.
2. Evidence over vibes. Every sub-score carries a verbatim evidence string from the video. A label without evidence is worthless.
3. Be adversarial, then honest. First grade optimistically (how the creator sees it), then run the adversarial pass that tries to REFUTE the video, and report the calibrated (lower, realistic) score. The gap between them is the product — a 0-point gap means you rubber-stamped and failed.
4. Self-report quality. If there is no audio, set voice metrics to zero and quality.level to "partial" with a reason. If the video is unreadable, say "degraded". Never silently fabricate around missing data.

HOOK SCORING (0-100) — anchor to the CLOSEST of these six reference points and name it in calibration_anchor:
${anchors}
Decompose every hook into exactly these six signals, each 0-100 with evidence:
${hookSignals}
Then give would_fail_because (the single biggest scroll-past risk) and exactly three stronger rewrites that keep the creator's intent.

VIRAL DNA (0-100 each), grounded in the video:
${dna}

ADVERSARIAL VIRALITY PASS — produce an optimistic_score, then attack the video on each vector and mark it present (un-mitigated) or mitigated. virality_score is the calibrated number AFTER the attacks. calibration_gap = optimistic_score - virality_score. Map virality_score to a verdict: SHIP (>=72), REWORK (>=45), NO-GO (<45). Attack vectors:
${vectors}

TEMPLATE MATCH — name the closest proven viral template, its hook pattern and portable format structure, and why this video fits it.

VOICE DNA — qualitative profile (energy, humor, vocabulary, pacing, signature moves) PLUS reproducible numeric metrics computed from the transcript: type-token ratio (vocab_diversity_ttr, 0-1), filler_rate_per_100_words, avg_sentence_length_words, total_words, and the top 5 signature 2-3-gram phrases with counts. If there is no spoken/written language, zero them and flag quality.

TRENDS — name rising formats/topics this video rides (qualitative growth label only: Early signal / Rising / Accelerating / Peaking — NEVER fabricate a percentage) and the saturated patterns it should retire.

RECOMMENDATIONS — ranked, concrete, do-this-next actions, most impactful first.

Detect the niche from the 17 canonical Nonelab niches. Return ONLY the JSON object matching the provided schema — no prose outside it.`;
}

/**
 * The per-request user prompt. Carries the caller's hints (niche, platform)
 * and the framing for whichever source (uploaded file vs. URL) is attached.
 */
function buildUserPrompt({ niche, platform, sourceLabel } = {}) {
  const nicheHint = niche && NICHES.includes(niche)
    ? `The creator says the target niche is "${niche}" — confirm or correct it from what you see.`
    : 'Infer the niche from the content.';
  const platformHint = platform && PLATFORMS.includes(platform)
    ? `Target platform: ${platform} — weight hook/pacing norms for that surface.`
    : 'Assume a generic short-form vertical feed.';

  return `Analyze this short-form video${sourceLabel ? ` (${sourceLabel})` : ''} end to end with the full Nonelab framework.
${nicheHint}
${platformHint}

Watch the first 2 seconds with special care — that is where the hook lives and where retention is won or lost. Transcribe the opening words verbatim. Then complete every section of the schema with evidence. Run the adversarial pass honestly: your job is to find why it might fail, not to cheer for it.`;
}

module.exports = {
  NICHES,
  PLATFORMS,
  HOOK_CALIBRATION_ANCHORS,
  HOOK_SIGNALS,
  VIRAL_DNA_DIMENSIONS,
  ATTACK_VECTORS,
  VERDICTS,
  VOICE_PROFILE_FIELDS,
  VOICE_METRICS_FIELDS,
  QUALITY_LEVELS,
  analysisResponseSchema,
  buildSystemInstruction,
  buildUserPrompt,
};
