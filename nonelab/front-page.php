<?php
/**
 * Front page — the Nonelab home design.
 *
 * @package Nonelab
 */

get_header();

$brands_url  = nonelab_page_url( 'brands' );
$about_url   = nonelab_page_url( 'about' );
$partners_url = nonelab_page_url( 'partners' );
$contact_url = nonelab_page_url( 'contact' );
?>

<!-- ===================== HERO ===================== -->
<section class="hero">
	<div class="wrap hero-grid">
		<div class="hero-copy">
			<div class="eyebrow reveal" data-i18n="hero.eyebrow">Beauty &amp; Wellness Group · Vietnam</div>
			<h1 class="display reveal d1" style="margin-top:20px" data-i18n="hero.title">Beauty in your own way.</h1>
			<p class="lead reveal d2" style="max-width:500px;margin-top:24px" data-i18n="hero.body">We develop and distribute international-standard beauty &amp; wellness brands.</p>
			<div class="reveal d3" style="display:flex;gap:14px;margin-top:34px;flex-wrap:wrap">
				<a class="btn solid" href="<?php echo esc_url( $brands_url ); ?>"><span data-i18n="hero.cta1">Explore our brands</span><span class="arr">→</span></a>
				<a class="btn ghost" href="<?php echo esc_url( $about_url ); ?>" data-i18n="hero.cta2">Our story</a>
			</div>
			<div class="hero-stats reveal d4">
				<div class="hero-stat"><div class="num"><span data-count="5">5</span></div><div class="lbl" data-i18n="hs1l">Brands in portfolio</div></div>
				<div class="hero-stat"><div class="num"><span data-count="70000" data-suffix="+">70,000+</span></div><div class="lbl" data-i18n="hs2l">KOC &amp; KOL network</div></div>
				<div class="hero-stat"><div class="num"><span data-count="24" data-suffix="h">24h</span></div><div class="lbl" data-i18n="hs3l">Nationwide delivery</div></div>
			</div>
		</div>
		<div class="hero-visual reveal d2">
			<div class="hero-orb" data-parallax="0.12" style="width:clamp(80px,11vw,130px);height:clamp(80px,11vw,130px);top:-26px;left:-22px;box-shadow:0 24px 60px -12px rgba(255,106,27,.65)"></div>
			<div class="img-zoom main-img" style="position:absolute;inset:0;border-radius:28px">
				<img src="<?php echo esc_url( nonelab_asset( 'nerman-event.jpg' ) ); ?>" alt="Nerman event" loading="eager" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;border-radius:28px" />
			</div>
			<div data-parallax="0.06" style="position:absolute;bottom:26px;left:-38px;width:clamp(140px,18vw,196px);height:clamp(100px,13vw,128px);border-radius:18px;box-shadow:0 24px 50px -18px rgba(0,0,0,.3);border:5px solid var(--cream);background:#fff;display:flex;align-items:center;justify-content:center;padding:22px">
				<img src="<?php echo esc_url( nonelab_asset( 'nerman-logo.png' ) ); ?>" alt="Nerman" style="max-width:100%;max-height:46px;object-fit:contain" />
			</div>
			<div class="float-card" data-parallax="0.18" style="top:34px;right:-22px">
				<div style="font-size:12px;color:var(--muted)" data-i18n="float.tag">Top 1 · Men's care</div>
				<div style="font-weight:800;font-size:18px;letter-spacing:-.03em" data-i18n="float.brand">Nerman</div>
			</div>
		</div>
	</div>
</section>

<!-- ===================== MARQUEE ===================== -->
<section class="section tight" style="padding-top:0">
	<div class="wrap" style="margin-bottom:26px">
		<div class="eyebrow" style="text-align:center" data-i18n="mq.label">Our brands &amp; exclusive partners</div>
	</div>
	<div class="marquee">
		<div class="marquee-track">
			<span class="mq-item"><span class="dot"></span>Nerman</span>
			<span class="mq-item"><span class="dot"></span>Mistory</span>
			<span class="mq-item"><span class="dot"></span>Lion Bartender</span>
			<span class="mq-item"><span class="dot"></span>Menow</span>
			<span class="mq-item"><span class="dot"></span>Spenny</span>
		</div>
	</div>
</section>

<!-- ===================== ABOUT TEASER ===================== -->
<section class="section" id="about">
	<div class="wrap">
		<div style="display:grid;grid-template-columns:1fr 1.1fr;gap:clamp(30px,6vw,72px);align-items:start" class="about-grid">
			<div class="reveal">
				<div class="eyebrow" data-i18n="about.eyebrow">About Nonelab</div>
				<h2 class="section-title" style="margin-top:18px" data-i18n="about.title">We build the brands that shape modern self-care.</h2>
			</div>
			<div>
				<p class="lead reveal" data-i18n="about.body">Nonelab Group develops owned brands and distributes selective international labels.</p>
				<div style="margin-top:30px;display:flex;flex-direction:column;gap:2px">
					<div class="struct-row reveal d1" style="padding:18px 0;align-items:center;gap:16px">
						<span style="width:26px;height:26px;border-radius:50%;background:var(--grad);flex:none"></span>
						<span style="font-weight:500" data-i18n="about.p1">Owned brands, built and grown entirely in-house.</span>
					</div>
					<div class="struct-row reveal d2" style="padding:18px 0;align-items:center;gap:16px">
						<span style="width:26px;height:26px;border-radius:50%;background:var(--grad);flex:none"></span>
						<span style="font-weight:500" data-i18n="about.p2">Exclusive distribution of top Asian beauty brands.</span>
					</div>
					<div class="struct-row reveal d3" style="padding:18px 0;align-items:center;gap:16px">
						<span style="width:26px;height:26px;border-radius:50%;background:var(--grad);flex:none"></span>
						<span style="font-weight:500" data-i18n="about.p3">A powerful online distribution engine across major e-commerce platforms.</span>
					</div>
				</div>
				<a class="btn ghost reveal d3" href="<?php echo esc_url( $about_url ); ?>" style="margin-top:30px"><span data-i18n="about.cta">More about us</span><span class="arr">→</span></a>
			</div>
		</div>
	</div>
</section>

<!-- ===================== VISION QUOTE ===================== -->
<section class="section tight">
	<div class="wrap">
		<div class="reveal" style="border-top:1px solid var(--line);border-bottom:1px solid var(--line);padding:clamp(40px,6vw,64px) 0;text-align:center">
			<p style="font-family:var(--disp);font-weight:600;font-size:clamp(26px,3.6vw,46px);line-height:1.18;letter-spacing:-.02em;max-width:1000px;margin:0 auto" data-i18n="about.vision">“Beauty in your own way.”</p>
		</div>
	</div>
</section>

<!-- ===================== STRUCTURE ===================== -->
<section class="section" id="structure">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(36px,5vw,56px)">
			<div class="eyebrow" data-i18n="struct.eyebrow">Group structure</div>
			<h2 class="section-title" style="margin-top:16px" data-i18n="struct.title">One group, four engines of growth.</h2>
		</div>
		<div>
			<div class="struct-row reveal">
				<span class="tag" data-i18n="struct.r1tag">Owned Brands</span>
				<h3 data-i18n="struct.r1h">Nerman · Mistory · Lion Bartender</h3>
				<span class="meta" data-i18n="struct.r1m">Built, owned and grown in-house.</span>
			</div>
			<div class="struct-row reveal d1">
				<span class="tag" data-i18n="struct.r2tag">Exclusive Distribution</span>
				<h3 data-i18n="struct.r2h">Menow · Spenny</h3>
				<span class="meta" data-i18n="struct.r2m">Sole distributor in the Vietnam market.</span>
			</div>
			<div class="struct-row reveal d2">
				<span class="tag" data-i18n="struct.r4tag">Online Distribution</span>
				<h3 data-i18n="struct.r4h">E-commerce platforms</h3>
				<span class="meta" data-i18n="struct.r4m">Shopee · TikTok Shop · Lazada.</span>
			</div>
			<div class="struct-row reveal d3" style="border-bottom:1px solid var(--line)">
				<span class="tag" data-i18n="struct.r3tag">Offline Channels</span>
				<h3 data-i18n="struct.r3h">General &amp; Modern Trade</h3>
				<span class="meta" data-i18n="struct.r3m">Nationwide retail coverage, GT &amp; MT.</span>
			</div>
		</div>
	</div>
</section>

<!-- ===================== CAPABILITIES ===================== -->
<section class="section band-dark">
	<div class="wrap">
		<div class="reveal" style="max-width:720px;margin-bottom:clamp(44px,6vw,72px)">
			<div class="eyebrow" data-i18n="cap.eyebrow">Our capabilities</div>
			<h2 class="section-title" style="margin-top:16px;color:#fff" data-i18n="cap.title">Built to move fast, nationwide.</h2>
		</div>

		<div class="feature" style="margin-bottom:clamp(56px,8vw,96px)">
			<div class="feat-text reveal">
				<span class="chip" data-i18n="cap.whChip">Logistics</span>
				<h3 style="color:#fff;font-size:clamp(24px,2.8vw,34px);margin-top:22px" data-i18n="cap.whH">Nationwide delivery within 24 hours.</h3>
				<p class="lead" style="margin-top:16px;max-width:480px" data-i18n="cap.whBody">Two central warehouses in Hanoi and Ho Chi Minh City power rapid delivery across the country.</p>
				<div style="display:flex;gap:40px;margin-top:30px">
					<div><div style="font-family:var(--disp);font-size:30px;font-weight:700">2</div><div style="color:rgba(255,255,255,.55);font-size:14px" data-i18n="cap.whK1">Central warehouses</div></div>
					<div><div style="font-family:var(--disp);font-size:30px;font-weight:700">2,000m²+</div><div style="color:rgba(255,255,255,.55);font-size:14px" data-i18n="cap.whK2">HCMC warehouse</div></div>
				</div>
			</div>
			<div class="reveal d1" style="border-radius:24px;border:1px solid rgba(255,255,255,.12);background:linear-gradient(135deg,rgba(255,106,27,.16),rgba(255,255,255,.02));min-height:clamp(230px,28vw,320px);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:40px">
				<div class="feature-num grad-text" style="font-size:clamp(64px,10vw,124px);line-height:1"><span data-count="24" data-suffix="h">24h</span></div>
				<div style="color:rgba(255,255,255,.6);font-size:14.5px;letter-spacing:.04em;margin-top:10px" data-i18n="hs3l">Nationwide delivery</div>
			</div>
		</div>

		<div class="feature flip">
			<div class="feat-text reveal">
				<span class="chip" data-i18n="cap.kolChip">Influence</span>
				<h3 style="color:#fff;font-size:clamp(24px,2.8vw,34px);margin-top:22px" data-i18n="cap.kolH">A KOC &amp; KOL network at national scale.</h3>
				<p class="lead" style="margin-top:16px;max-width:480px" data-i18n="cap.kolBody">Pioneering KOL engagement on TikTok in Vietnam since 2018.</p>
				<div style="display:flex;gap:40px;margin-top:30px">
					<div><div style="font-family:var(--disp);font-size:30px;font-weight:700"><span data-count="1000" data-suffix="+">1,000+</span></div><div style="color:rgba(255,255,255,.55);font-size:14px" data-i18n="cap.kolK1">videos / reviews</div></div>
					<div><div style="font-family:var(--disp);font-size:30px;font-weight:700"><span data-count="20" data-suffix="M+">20M+</span></div><div style="color:rgba(255,255,255,.55);font-size:14px" data-i18n="cap.kolK2">reach every month</div></div>
				</div>
			</div>
			<div class="reveal d1" style="border-radius:24px;border:1px solid rgba(255,255,255,.12);background:linear-gradient(135deg,rgba(255,106,27,.16),rgba(255,255,255,.02));min-height:clamp(230px,28vw,320px);display:flex;flex-direction:column;align-items:center;justify-content:center;text-align:center;padding:40px">
				<div class="feature-num grad-text" style="font-size:clamp(52px,8vw,104px);line-height:1"><span data-count="70000" data-suffix="+">70,000+</span></div>
				<div style="color:rgba(255,255,255,.6);font-size:14.5px;letter-spacing:.04em;margin-top:10px" data-i18n="hs2l">KOC &amp; KOL network</div>
			</div>
		</div>
	</div>
</section>

<!-- ===================== OWNED BRANDS ===================== -->
<section class="section" id="brands">
	<div class="wrap">
		<div class="reveal" style="margin-bottom:clamp(36px,5vw,56px)">
			<div class="eyebrow" data-i18n="brands.eyebrow">Our brands</div>
			<h2 class="section-title" style="margin-top:16px" data-i18n="brands.title">Names people love.</h2>
		</div>
		<div class="grid cols-3">
			<a class="brand-card reveal" href="<?php echo esc_url( $brands_url ); ?>">
				<div style="height:clamp(140px,16vw,184px);background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:28px">
					<img src="<?php echo esc_url( nonelab_asset( 'nerman-logo.png' ) ); ?>" alt="Nerman" style="max-width:76%;max-height:52px;object-fit:contain" />
				</div>
				<div class="bc-body">
					<div class="bc-tag" data-i18n="brands.nTag">Owned · Men's care</div>
					<p style="color:var(--muted);margin-top:12px" data-i18n="brands.nBody">The #1 men's beauty and grooming brand in Vietnam.</p>
					<div style="margin-top:18px;font-weight:600;color:var(--b1)"><span data-i18n="brands.link">View brand</span> →</div>
				</div>
			</a>
			<a class="brand-card reveal d1" href="<?php echo esc_url( $brands_url ); ?>">
				<div style="height:clamp(140px,16vw,184px);background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:28px">
					<img src="<?php echo esc_url( nonelab_asset( 'mistory-logo.png' ) ); ?>" alt="Mistory" style="max-width:78%;max-height:60px;object-fit:contain" />
				</div>
				<div class="bc-body">
					<div class="bc-tag" data-i18n="brands.mTag">Owned · Make-up</div>
					<p style="color:var(--muted);margin-top:12px" data-i18n="brands.mBody">A Vietnamese beauty brand celebrating the timeless essence of Vietnamese women.</p>
					<div style="margin-top:18px;font-weight:600;color:var(--b1)"><span data-i18n="brands.link">View brand</span> →</div>
				</div>
			</a>
			<a class="brand-card reveal d2" href="<?php echo esc_url( $brands_url ); ?>">
				<div style="height:clamp(140px,16vw,184px);background:linear-gradient(135deg,#1a1206,#3a2a10);display:flex;align-items:center;justify-content:center;padding:20px">
					<img src="<?php echo esc_url( nonelab_asset( 'lion-logo.png' ) ); ?>" alt="Lion Bartender" style="max-width:58%;max-height:104px;object-fit:contain" />
				</div>
				<div class="bc-body">
					<div class="bc-tag" data-i18n="brands.lTag">Owned · Grooming</div>
					<p style="color:var(--muted);margin-top:12px" data-i18n="brands.lBody">A bold men's grooming line developed in-house by Nonelab.</p>
					<div style="margin-top:18px;font-weight:600;color:var(--b1)"><span data-i18n="brands.link">View brand</span> →</div>
				</div>
			</a>
		</div>
	</div>
</section>

<!-- ===================== DISTRIBUTION & ONLINE ===================== -->
<section class="section tight" style="padding-top:0">
	<div class="wrap">
		<div class="reveal" style="margin-bottom:clamp(28px,4vw,44px)">
			<div class="eyebrow" data-i18n="dist.eyebrow">Exclusive distribution &amp; online</div>
			<h2 class="section-title" style="margin-top:16px;font-size:clamp(28px,3.4vw,44px)" data-i18n="dist.title">Top brands and a powerful online engine.</h2>
		</div>
		<div class="grid cols-2" style="margin-bottom:24px">
			<!-- Menow -->
			<div class="brand-card reveal">
				<div style="height:clamp(130px,15vw,172px);background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:26px">
					<img src="<?php echo esc_url( nonelab_asset( 'menow-logo.png' ) ); ?>" alt="Menow" style="max-width:88%;max-height:74px;object-fit:contain" />
				</div>
				<div class="bc-body">
					<div class="bc-tag" data-i18n="dist.menowTag">Exclusive · Make-up</div>
					<p style="color:var(--muted);margin-top:12px" data-i18n="dist.menowBody">China's most-loved makeup brand, distributed exclusively by Nonelab in Vietnam.</p>
				</div>
			</div>
			<!-- Spenny -->
			<div class="brand-card reveal d1">
				<div style="height:clamp(130px,15vw,172px);background:linear-gradient(135deg,#5B57C9,#37A7C2);display:flex;align-items:flex-end;padding:20px 24px">
					<span style="font-family:var(--disp);font-weight:700;font-size:clamp(26px,2.8vw,36px);color:#fff;letter-spacing:-.03em">Spenny</span>
				</div>
				<div class="bc-body">
					<div class="bc-tag" data-i18n="dist.spennyTag">Exclusive distribution</div>
					<p style="color:var(--muted);margin-top:12px" data-i18n="dist.spennyBody">An exclusive partner brand distributed by Nonelab in Vietnam.</p>
				</div>
			</div>
		</div>
		<!-- Online distribution panel -->
		<div class="reveal about-grid" style="border-radius:24px;background:var(--ink);color:#fff;padding:clamp(28px,3.4vw,44px);display:grid;grid-template-columns:1.4fr 1fr;gap:clamp(24px,4vw,48px);align-items:center">
			<div>
				<span class="chip" data-i18n="dist.onlineTag">Online distribution</span>
				<h3 style="color:#fff;margin-top:18px;font-size:clamp(24px,2.6vw,32px)" data-i18n="dist.onlineH">Selling everywhere customers shop.</h3>
				<p style="color:rgba(255,255,255,.66);margin-top:14px;font-size:16px;max-width:540px" data-i18n="dist.onlineBody">A dedicated online distribution engine across Vietnam's biggest e-commerce platforms.</p>
				<div style="display:flex;gap:10px;margin-top:24px;flex-wrap:wrap">
					<span style="padding:10px 18px;border:1px solid rgba(255,255,255,.2);border-radius:100px;font-weight:600;font-size:14.5px" data-i18n="dist.p1">TikTok Shop</span>
					<span style="padding:10px 18px;border:1px solid rgba(255,255,255,.2);border-radius:100px;font-weight:600;font-size:14.5px" data-i18n="dist.p2">Shopee</span>
					<span style="padding:10px 18px;border:1px solid rgba(255,255,255,.2);border-radius:100px;font-weight:600;font-size:14.5px" data-i18n="dist.p3">Lazada</span>
				</div>
			</div>
			<div>
				<div class="feature-num grad-text" style="font-size:clamp(48px,6vw,84px);line-height:1"><span data-count="3" data-suffix="M+">3M+</span></div>
				<div style="color:rgba(255,255,255,.55);font-size:14.5px;margin-top:6px" data-i18n="dist.onlineStat">reach every month</div>
			</div>
		</div>
	</div>
</section>

<!-- ===================== AWARDS ===================== -->
<section class="section" id="awards" style="background:var(--cream-2)">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(36px,5vw,56px)">
			<div class="eyebrow" data-i18n="aw.eyebrow">Recognition</div>
			<h2 class="section-title" style="margin-top:16px" data-i18n="aw.title">Award-winning brands.</h2>
			<p class="lead" style="margin-top:18px" data-i18n="aw.body">Our work is recognised by the platforms and the industry that shape beauty retail in Vietnam.</p>
		</div>
		<div class="grid cols-3">
			<div class="card reveal" style="padding:clamp(28px,3vw,38px)">
				<div style="display:flex;align-items:center;justify-content:space-between">
					<div style="width:46px;height:46px;border-radius:50%;background:var(--grad);box-shadow:0 10px 24px -8px rgba(255,106,27,.6)"></div>
					<span style="font-family:var(--disp);font-weight:700;font-size:22px;color:var(--muted-2)" data-i18n="aw.a1y">2023</span>
				</div>
				<h3 style="font-size:clamp(22px,2.2vw,27px);margin-top:22px" data-i18n="aw.a1t">Brand of the Year</h3>
				<p style="color:var(--muted);margin-top:8px" data-i18n="aw.a1b">TikTok Shop — Health &amp; Beauty</p>
			</div>
			<div class="card reveal d1" style="padding:clamp(28px,3vw,38px)">
				<div style="display:flex;align-items:center;justify-content:space-between">
					<div style="width:46px;height:46px;border-radius:50%;background:var(--grad);box-shadow:0 10px 24px -8px rgba(255,106,27,.6)"></div>
					<span style="font-family:var(--disp);font-weight:700;font-size:22px;color:var(--muted-2)" data-i18n="aw.a2y">2024</span>
				</div>
				<h3 style="font-size:clamp(22px,2.2vw,27px);margin-top:22px" data-i18n="aw.a2t">Best Local Hero Brand</h3>
				<p style="color:var(--muted);margin-top:8px" data-i18n="aw.a2b">Recognised for category leadership in Vietnam</p>
			</div>
			<div class="card reveal d2" style="padding:clamp(28px,3vw,38px)">
				<div style="display:flex;align-items:center;justify-content:space-between">
					<div style="width:46px;height:46px;border-radius:50%;border:3px solid var(--b1)"></div>
					<span style="font-family:var(--disp);font-weight:700;font-size:22px;color:var(--muted-2)" data-i18n="aw.a3y">2024</span>
				</div>
				<h3 style="font-size:clamp(22px,2.2vw,27px);margin-top:22px" data-i18n="aw.a3t">Top 1 Men's Care</h3>
				<p style="color:var(--muted);margin-top:8px" data-i18n="aw.a3b">Nerman — e-commerce, Vietnam</p>
			</div>
		</div>
	</div>
</section>

<!-- ===================== TOP 1 E-COMMERCE ===================== -->
<section class="section" style="padding-top:0">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(34px,5vw,52px)">
			<div class="eyebrow" data-i18n="top.eyebrow">#1 on e-commerce</div>
			<h2 class="section-title" style="margin-top:16px" data-i18n="top.title">Our brands top the charts.</h2>
			<p class="lead" style="margin-top:18px" data-i18n="top.body">Across Vietnam's biggest e-commerce platforms, Nonelab brands rank #1 in their categories — month after month.</p>
		</div>
		<div class="grid cols-4">
			<div class="reveal">
				<div style="position:relative;border-radius:18px;overflow:hidden;border:1px solid var(--line-2);background:#fff;aspect-ratio:9/16">
					<img src="<?php echo esc_url( nonelab_asset( 'top-menow.jpg' ) ); ?>" alt="Menow #1 on e-commerce" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block" />
					<span style="position:absolute;top:12px;left:12px;background:var(--grad);color:#fff;font-family:var(--disp);font-weight:700;font-size:14px;padding:4px 12px;border-radius:100px;box-shadow:0 6px 16px -4px rgba(255,106,27,.6)">#1</span>
				</div>
				<div style="margin-top:14px">
					<div style="font-weight:700;font-family:var(--disp);font-size:18px">Menow</div>
					<div style="color:var(--muted);font-size:14px;margin-top:2px" data-i18n="top.c1">Face powder · 23.7K sold / month</div>
				</div>
			</div>
			<div class="reveal d1">
				<div style="position:relative;border-radius:18px;overflow:hidden;border:1px solid var(--line-2);background:#fff;aspect-ratio:9/16">
					<img src="<?php echo esc_url( nonelab_asset( 'top-mistory.jpg' ) ); ?>" alt="Mistory #1 on e-commerce" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block" />
					<span style="position:absolute;top:12px;left:12px;background:var(--grad);color:#fff;font-family:var(--disp);font-weight:700;font-size:14px;padding:4px 12px;border-radius:100px;box-shadow:0 6px 16px -4px rgba(255,106,27,.6)">#1</span>
				</div>
				<div style="margin-top:14px">
					<div style="font-weight:700;font-family:var(--disp);font-size:18px">Mistory</div>
					<div style="color:var(--muted);font-size:14px;margin-top:2px" data-i18n="top.c2">Blush · #1 trending</div>
				</div>
			</div>
			<div class="reveal d2">
				<div style="position:relative;border-radius:18px;overflow:hidden;border:1px solid var(--line-2);background:#fff;aspect-ratio:9/16">
					<img src="<?php echo esc_url( nonelab_asset( 'top-lion.jpg' ) ); ?>" alt="Lion Bartender #1 on e-commerce" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block" />
					<span style="position:absolute;top:12px;left:12px;background:var(--grad);color:#fff;font-family:var(--disp);font-weight:700;font-size:14px;padding:4px 12px;border-radius:100px;box-shadow:0 6px 16px -4px rgba(255,106,27,.6)">#1</span>
				</div>
				<div style="margin-top:14px">
					<div style="font-weight:700;font-family:var(--disp);font-size:18px">Lion Bartender</div>
					<div style="color:var(--muted);font-size:14px;margin-top:2px" data-i18n="top.c3">3-in-1 body wash · #1 trending</div>
				</div>
			</div>
			<div class="reveal d3">
				<div style="position:relative;border-radius:18px;overflow:hidden;border:1px solid var(--line-2);background:#fff;aspect-ratio:9/16">
					<img src="<?php echo esc_url( nonelab_asset( 'top-nerman.jpg' ) ); ?>" alt="Nerman top ranked on e-commerce" loading="lazy" style="width:100%;height:100%;object-fit:cover;object-position:top;display:block" />
					<span style="position:absolute;top:12px;left:12px;background:var(--grad);color:#fff;font-family:var(--disp);font-weight:700;font-size:14px;padding:4px 12px;border-radius:100px;box-shadow:0 6px 16px -4px rgba(255,106,27,.6)">Top</span>
				</div>
				<div style="margin-top:14px">
					<div style="font-weight:700;font-family:var(--disp);font-size:18px">Nerman</div>
					<div style="color:var(--muted);font-size:14px;margin-top:2px" data-i18n="top.c4">Health &amp; Beauty · top ranked</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ===================== PARTNERS ===================== -->
<section class="section" id="partners">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(36px,5vw,56px)">
			<div class="eyebrow" data-i18n="part.eyebrow">Our partners</div>
			<h2 class="section-title" style="margin-top:16px" data-i18n="part.title">Trusted across Vietnam's biggest retail networks.</h2>
		</div>
		<div class="count-grid reveal" style="margin-bottom:clamp(40px,5vw,56px)">
			<div class="count-item"><div class="big grad-text"><span data-count="4200" data-suffix="+">4,200+</span></div><div class="small" data-i18n="part.c1l">Supermarket points nationwide</div></div>
			<div class="count-item"><div class="big grad-text"><span data-count="500" data-suffix="+">500+</span></div><div class="small" data-i18n="part.c2l">Cosmetic chain stores</div></div>
			<div class="count-item"><div class="big grad-text"><span data-count="150" data-suffix="+">150+</span></div><div class="small" data-i18n="part.c3l">Retail branches</div></div>
			<div class="count-item"><div class="big grad-text"><span data-count="16" data-suffix="+">16+</span></div><div class="small" data-i18n="part.c4l">Distribution partners</div></div>
		</div>
		<div class="grid cols-4 reveal d1">
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/winmart.png' ) ); ?>" alt="WinMart+" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/aeon.png' ) ); ?>" alt="AEON" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/lottemart.png' ) ); ?>" alt="LOTTE Mart" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/bachhoaxanh.png' ) ); ?>" alt="Bách hóa Xanh" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/circlek.png' ) ); ?>" alt="Circle K" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/7eleven.png' ) ); ?>" alt="7-Eleven" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/gs25.png' ) ); ?>" alt="GS25" loading="lazy" /></div>
			<div class="logo-cell big"><img src="<?php echo esc_url( nonelab_asset( 'partners/guardian.png' ) ); ?>" alt="Guardian" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/medicare.png' ) ); ?>" alt="Medicare" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/watsons.png' ) ); ?>" alt="Watsons" loading="lazy" /></div>
			<div class="logo-cell"><img src="<?php echo esc_url( nonelab_asset( 'partners/kkv.png' ) ); ?>" alt="KKV" loading="lazy" /></div>
			<div class="logo-cell big"><img src="<?php echo esc_url( nonelab_asset( 'partners/cocolux.png' ) ); ?>" alt="Cocolux" loading="lazy" /></div>
		</div>
		<div class="reveal d1" style="margin-top:30px">
			<a class="btn ghost" href="<?php echo esc_url( $partners_url ); ?>"><span data-i18n="part.cta">See all partners</span><span class="arr">→</span></a>
		</div>
	</div>
</section>

<!-- ===================== CTA ===================== -->
<section class="section" style="padding-top:0">
	<div class="wrap">
		<div class="cta-band reveal">
			<div class="hero-orb" style="width:300px;height:300px;background:rgba(255,255,255,.14);top:-120px;right:-80px"></div>
			<div style="position:relative;z-index:2">
				<h2 class="section-title" style="max-width:760px;margin:0 auto" data-i18n="cta.title">Let's build the next brand people love.</h2>
				<p style="font-size:18px;max-width:540px;margin:20px auto 0;color:rgba(255,255,255,.9)" data-i18n="cta.body">Bring your brand to Vietnam and Southeast Asia.</p>
				<a class="btn reveal" href="<?php echo esc_url( $contact_url ); ?>" style="background:#fff;color:var(--ink);margin-top:30px"><span data-i18n="cta.btn">Partner with us</span><span class="arr">→</span></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
