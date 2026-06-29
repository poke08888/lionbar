/* Nonelab Studio — front-end controller. Vanilla JS, no build step. */
(() => {
  'use strict';

  const $ = (sel, root = document) => root.querySelector(sel);
  const el = (tag, cls, html) => {
    const n = document.createElement(tag);
    if (cls) n.className = cls;
    if (html != null) n.innerHTML = html;
    return n;
  };
  const esc = (s) => String(s ?? '').replace(/[&<>"]/g, (c) => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;' }[c]));
  const scoreColor = (v) => (v >= 72 ? 'var(--good)' : v >= 45 ? 'var(--warn)' : 'var(--bad)');

  /* ---------- bootstrap: health + meta ---------- */
  async function boot() {
    try {
      const health = await fetch('/api/health').then((r) => r.json());
      const pill = $('#health-pill');
      $('#foot-model').textContent = `model: ${health.model}`;
      $('#brand-model').textContent = health.model;
      if (health.gemini_key_configured) {
        pill.textContent = 'API ready';
        pill.className = 'pill pill-ok';
      } else {
        pill.textContent = 'no Gemini key';
        pill.className = 'pill pill-bad';
        pill.title = 'Set GEMINI_API_KEY in the server environment.';
      }
    } catch {
      $('#health-pill').textContent = 'offline';
      $('#health-pill').className = 'pill pill-bad';
    }

    try {
      const meta = await fetch('/api/meta').then((r) => r.json());
      const sel = $('#niche');
      meta.niches.forEach((n) => sel.appendChild(el('option', null, n))) ;
      sel.querySelectorAll('option').forEach((o) => { if (o.value === '') return; o.value = o.textContent; });
      renderFramework(meta);
    } catch { /* non-fatal */ }
  }

  function renderFramework(meta) {
    const grid = $('#framework-grid');
    const cards = [
      ['Hook score', '0–100 with six evidence-backed signals, a calibration anchor (10/30/50/70/85/95) and three rewrites.'],
      ['Viral DNA', 'Viral-DNA, replicability, originality, consistency and audience-fatigue, each grounded in the video.'],
      ['Adversarial virality', 'An optimistic grade, then an attack pass — the calibrated score and the gap are the honest signal.'],
      ['Template match', 'The closest proven viral template: hook pattern + portable format structure.'],
      ['Voice DNA', 'Energy, humor, vocabulary, plus reproducible metrics: TTR, filler rate, sentence length, signature phrases.'],
      ['Trend fit', 'Rising formats the video rides and saturated patterns to retire.'],
      ['Recommendations', 'Ranked, concrete do-this-next actions, most impactful first.'],
    ];
    cards.forEach(([t, d]) => {
      const c = el('div', 'fw-card');
      c.appendChild(el('div', 'fw-t', esc(t)));
      c.appendChild(el('div', 'fw-d', esc(d)));
      grid.appendChild(c);
    });
  }

  /* ---------- source tabs ---------- */
  let activeTab = 'url';
  document.querySelectorAll('.tab').forEach((tab) => {
    tab.addEventListener('click', () => {
      activeTab = tab.dataset.tab;
      document.querySelectorAll('.tab').forEach((t) => t.classList.toggle('active', t === tab));
      document.querySelectorAll('.tab-body').forEach((b) => b.classList.toggle('hidden', b.dataset.body !== activeTab));
    });
  });

  /* ---------- dropzone ---------- */
  const fileInput = $('#video');
  const dz = $('#dropzone');
  const dzFile = $('#dz-file');
  fileInput.addEventListener('change', () => { dzFile.textContent = fileInput.files[0]?.name || ''; });
  ['dragover', 'dragenter'].forEach((ev) => dz.addEventListener(ev, (e) => { e.preventDefault(); dz.classList.add('drag'); }));
  ['dragleave', 'drop'].forEach((ev) => dz.addEventListener(ev, (e) => { e.preventDefault(); dz.classList.remove('drag'); }));
  dz.addEventListener('drop', (e) => {
    const f = e.dataTransfer.files[0];
    if (f) { fileInput.files = e.dataTransfer.files; dzFile.textContent = f.name; }
  });

  /* ---------- submit ---------- */
  const form = $('#analyze-form');
  const statusEl = $('#status');
  const resultsEl = $('#results');
  const btn = $('#submit-btn');

  function setStatus(html, isErr) {
    statusEl.className = `status${isErr ? ' err' : ''}`;
    statusEl.innerHTML = isErr ? html : `<span class="spinner"></span><span>${html}</span>`;
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const fd = new FormData();
    const url = $('#url').value.trim();
    const file = fileInput.files[0];

    if (activeTab === 'url' && !url) return setStatus('Paste a video URL first.', true);
    if (activeTab === 'file' && !file) return setStatus('Choose a video file first.', true);
    if (activeTab === 'url') fd.append('url', url);
    if (activeTab === 'file') fd.append('video', file);
    fd.append('niche', $('#niche').value);
    fd.append('platform', $('#platform').value);

    btn.disabled = true;
    resultsEl.classList.add('hidden');
    resultsEl.innerHTML = '';
    setStatus('Uploading & watching the video with Gemini — this can take 20–90s for a full analysis…');

    try {
      const res = await fetch('/api/analyze', { method: 'POST', body: fd });
      const data = await res.json();
      if (!res.ok || !data.ok) throw new Error(data.error || `Request failed (${res.status})`);
      statusEl.classList.add('hidden');
      render(data);
    } catch (err) {
      setStatus(`<strong>Analysis failed.</strong> ${esc(err.message)}`, true);
    } finally {
      btn.disabled = false;
    }
  });

  /* ---------- render ---------- */
  function card(title, aside) {
    const c = el('section', 'card');
    c.appendChild(el('h3', null, esc(title) + (aside ? `<span class="h3-aside">${esc(aside)}</span>` : '')));
    return c;
  }

  function signalBars(signals) {
    const wrap = el('div', 'bars');
    (signals || []).forEach((s) => {
      const v = Math.max(0, Math.min(100, Math.round(s.score)));
      const row = el('div', 'bar-row');
      row.appendChild(el('div', 'bl', esc(s.name)));
      const track = el('div', 'bar-track');
      const fill = el('div', 'bar-fill');
      fill.style.width = v + '%';
      track.appendChild(fill);
      row.appendChild(track);
      row.appendChild(el('div', 'bar-val', String(v)));
      if (s.evidence) row.appendChild(el('div', 'bar-ev', '“' + esc(s.evidence) + '”'));
      wrap.appendChild(row);
    });
    return wrap;
  }

  function render(data) {
    const a = data.analysis;
    resultsEl.innerHTML = '';
    resultsEl.classList.remove('hidden');

    /* quality flag */
    if (a.quality && a.quality.level !== 'full') {
      resultsEl.appendChild(el('div', `quality-flag ${esc(a.quality.level)}`,
        `<strong>${esc(a.quality.level.toUpperCase())} data:</strong> ${esc(a.quality.reason)}`));
    }

    /* summary */
    const sum = card('Summary');
    sum.classList.add('summary-card');
    sum.appendChild(el('p', 'summary-text', esc(a.summary)));
    const meta = el('div', 'summary-meta');
    meta.appendChild(el('span', 'chip', `Niche: <strong>${esc(a.detected_niche)}</strong>`));
    meta.appendChild(el('span', 'chip', `Format: <strong>${esc(a.format_fingerprint)}</strong>`));
    meta.appendChild(el('span', 'chip', `Source: <strong>${esc(data.source?.name || data.source?.label || '—')}</strong>`));
    meta.appendChild(el('span', 'chip', `Model: <strong>${esc(data.model)}</strong>`));
    sum.appendChild(meta);
    resultsEl.appendChild(sum);

    /* hook */
    const h = a.hook || {};
    const hc = card('Hook score');
    const head = el('div', 'scorehead');
    const ring = el('div', 'ring');
    ring.style.setProperty('--val', h.score || 0);
    ring.style.setProperty('--col', scoreColor(h.score || 0));
    ring.appendChild(el('span', null, String(h.score ?? '—')));
    head.appendChild(ring);
    const shMeta = el('div', 'sh-meta');
    shMeta.appendChild(el('div', 'sh-pattern', esc(h.matched_pattern || '')));
    shMeta.appendChild(el('div', 'sh-anchor', `Anchor: ${esc(h.calibration_anchor || '')}`));
    if (h.percentile != null) shMeta.appendChild(el('div', 'sh-anchor', `~${esc(h.percentile)}th percentile of hooks`));
    if (h.opening_text) shMeta.appendChild(el('div', 'sh-anchor', `Opening: “${esc(h.opening_text)}”`));
    head.appendChild(shMeta);
    hc.appendChild(head);
    hc.appendChild(signalBars(h.signals));
    if (h.would_fail_because) hc.appendChild(el('div', 'would-fail', `<b>Would fail because:</b> ${esc(h.would_fail_because)}`));
    if (h.rewrites?.length) {
      const ul = el('ul', 'rewrites');
      h.rewrites.forEach((r) => ul.appendChild(el('li', null, esc(r))));
      hc.appendChild(ul);
    }
    resultsEl.appendChild(hc);

    /* viral DNA + virality side by side */
    const row = el('div', 'grid-2');

    const dna = a.viral_dna || {};
    const dc = card('Viral DNA');
    const dnaSignals = [
      { name: 'Viral DNA', score: dna.viral_dna_score },
      { name: 'Replicability', score: dna.replicability_score },
      { name: 'Originality', score: dna.originality_score },
      { name: 'Consistency', score: dna.consistency_score },
      { name: 'Audience fatigue ⚠', score: dna.audience_fatigue },
    ];
    dc.appendChild(signalBars(dnaSignals));
    if (dna.would_fail_because) dc.appendChild(el('div', 'would-fail', `<b>Risk:</b> ${esc(dna.would_fail_because)}`));
    row.appendChild(dc);

    const vp = a.virality_prediction || {};
    const vc = card('Adversarial virality');
    const vrow = el('div', 'verdict-row');
    vrow.appendChild(el('span', `verdict-badge v-${esc(vp.verdict)}`, esc(vp.verdict)));
    vrow.appendChild(el('span', 'muted', esc(vp.reason || '')));
    vc.appendChild(vrow);
    const calib = el('div', 'calib');
    calib.appendChild(el('div', 'opt', `<div class="num">${esc(vp.optimistic_score)}</div><div class="lbl">Optimistic</div>`));
    calib.appendChild(el('div', 'gap', `<div class="num">−${esc(vp.calibration_gap)}</div><div class="lbl">Calibration gap</div>`));
    calib.appendChild(el('div', 'real', `<div class="num">${esc(vp.virality_score)}</div><div class="lbl">Calibrated${vp.score_range ? ' (' + esc(vp.score_range) + ')' : ''}</div>`));
    vc.appendChild(calib);
    vc.appendChild(el('p', 'calib-note', 'The optimistic score is the self-grade; the adversarial pass disagrees by the gap and lands at the calibrated number. A 0-point gap means the check rubber-stamped.'));
    const vlist = el('div', 'vectors');
    (vp.attack_vectors || []).forEach((v) => {
      const present = v.status === 'present';
      const item = el('div', `vector ${esc(v.status)}`);
      item.appendChild(el('span', 'vmark', present ? '✗' : '✓'));
      item.appendChild(el('div', null, `<strong>${esc(v.name)}</strong><span class="vnote">${esc(v.note)}</span>`));
      item.appendChild(el('span', `sev ${esc(v.severity)}`, esc(v.severity)));
      vlist.appendChild(item);
    });
    vc.appendChild(vlist);
    row.appendChild(vc);
    resultsEl.appendChild(row);

    /* template + voice */
    const row2 = el('div', 'grid-2');
    const t = a.template_match || {};
    const tc = card('Template match');
    const kv = el('dl', 'kv');
    const addKv = (k, v) => { if (v) { kv.appendChild(el('dt', null, esc(k))); kv.appendChild(el('dd', null, esc(v))); } };
    addKv('Template', t.name);
    addKv('Hook pattern', t.hook_pattern);
    addKv('Structure', t.format_structure);
    addKv('Performance', t.avg_views_band);
    addKv('Why it fits', t.why_it_fits);
    tc.appendChild(kv);
    row2.appendChild(tc);

    const v = a.voice || {};
    const m = v.metrics || {};
    const vo = card('Voice DNA');
    const vkv = el('dl', 'kv');
    [['Energy', v.energy], ['Humor', v.humor], ['Vocabulary', v.vocabulary], ['Pacing', v.pacing]].forEach(([k, val]) => {
      if (val) { vkv.appendChild(el('dt', null, k)); vkv.appendChild(el('dd', null, esc(val))); }
    });
    if (v.signature_moves?.length) {
      vkv.appendChild(el('dt', null, 'Signature'));
      vkv.appendChild(el('dd', null, esc(v.signature_moves.join(', '))));
    }
    vo.appendChild(vkv);
    const metrics = el('div', 'metrics');
    const mc = (val, lbl) => metrics.appendChild(el('div', 'metric', `<div class="mv">${esc(val)}</div><div class="ml">${esc(lbl)}</div>`));
    mc((m.vocab_diversity_ttr ?? 0).toFixed ? Number(m.vocab_diversity_ttr).toFixed(2) : m.vocab_diversity_ttr, 'Vocab TTR');
    mc(m.filler_rate_per_100_words ?? 0, 'Filler /100w');
    mc(m.avg_sentence_length_words ?? 0, 'Avg sentence');
    mc(m.total_words ?? 0, 'Total words');
    vo.appendChild(metrics);
    if (m.signature_phrases?.length) {
      const tl = el('div', 'taglist');
      m.signature_phrases.forEach((p) => tl.appendChild(el('span', 'tag', `${esc(p.phrase)} ·${esc(p.count)}`)));
      vo.appendChild(tl);
    }
    row2.appendChild(vo);
    resultsEl.appendChild(row2);

    /* trends */
    const tr = a.trends || {};
    if ((tr.aligned?.length || tr.saturated?.length)) {
      const trc = card('Trend fit');
      if (tr.aligned?.length) {
        trc.appendChild(el('div', 'muted', 'Riding (rising):'));
        const tl = el('div', 'taglist');
        tr.aligned.forEach((x) => tl.appendChild(el('span', 'tag rising', `${esc(x.label)} · ${esc(x.growth_label)}`)));
        trc.appendChild(tl);
      }
      if (tr.saturated?.length) {
        trc.appendChild(el('div', 'muted', 'Saturated (retire):'));
        const tl = el('div', 'taglist');
        tr.saturated.forEach((x) => tl.appendChild(el('span', 'tag sat', esc(x))));
        trc.appendChild(tl);
      }
      resultsEl.appendChild(trc);
    }

    /* recommendations */
    if (a.recommendations?.length) {
      const rc = card('Recommendations');
      const list = el('div', 'recs');
      a.recommendations.forEach((r) => {
        const item = el('div', 'rec');
        item.appendChild(el('span', `pr ${esc(r.priority)}`, esc(r.priority)));
        item.appendChild(el('div', null, `<div class="ra">${esc(r.action)}</div><div class="rr">${esc(r.rationale)}</div>`));
        list.appendChild(item);
      });
      rc.appendChild(list);
      resultsEl.appendChild(rc);
    }

    resultsEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
  }

  boot();
})();
