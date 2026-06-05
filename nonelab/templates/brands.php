<?php
/**
 * Template Name: Nonelab — Brands
 *
 * @package Nonelab
 */

get_header();
$contact_url = nonelab_page_url( 'contact' );
?>

<!-- ===== PAGE HERO ===== -->
<section class="section" style="padding-top:clamp(130px,16vh,180px);padding-bottom:clamp(30px,5vw,56px)">
	<div class="wrap">
		<div class="eyebrow reveal" data-i18n="br.eyebrow">Our brands</div>
		<h1 class="display reveal d1" style="margin-top:18px" data-i18n="br.title">The brands people love.</h1>
		<p class="lead reveal d2" style="max-width:640px;margin-top:24px" data-i18n="br.lead">From owned brands built in-house to top Asian labels we distribute exclusively.</p>
	</div>
</section>

<!-- ===== OWNED: NERMAN ===== -->
<section class="section tight">
	<div class="wrap">
		<div class="eyebrow reveal" style="margin-bottom:36px" data-i18n="br.ownedEyebrow">Owned brands</div>
		<div class="feature" style="margin-bottom:clamp(56px,8vw,90px)">
			<div class="feat-text reveal">
				<div class="bc-tag" style="color:var(--b1);font-size:12.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase" data-i18n="br.nTag">Owned · Men's care</div>
				<h2 class="section-title" style="font-size:clamp(34px,4.4vw,58px);margin:12px 0 18px" data-i18n="br.nName">Nerman</h2>
				<p class="lead" style="max-width:480px" data-i18n="br.nDesc">Nerman is the #1 men's beauty and grooming brand in Vietnam.</p>
				<div class="chip" style="margin-top:22px" data-i18n="br.nBadge">Top 1 men's care on e-commerce in Vietnam, 2024</div>
				<div style="display:flex;gap:44px;margin-top:30px">
					<div><div class="feature-num grad-text" style="font-size:clamp(34px,4vw,52px)"><span data-prefix="#" data-count="1">#1</span></div><div style="color:var(--muted);font-size:14px;margin-top:4px" data-i18n="br.nS1l">Men's care on e-commerce</div></div>
				</div>
			</div>
			<div class="reveal d1" style="border-radius:24px;height:clamp(300px,36vw,420px);background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:clamp(30px,4vw,52px)">
				<img src="<?php echo esc_url( nonelab_asset( 'nerman-logo.png' ) ); ?>" alt="Nerman" style="max-width:66%;max-height:80px;object-fit:contain" />
			</div>
		</div>

		<!-- OWNED: MISTORY -->
		<div class="feature flip">
			<div class="feat-text reveal">
				<div class="bc-tag" style="color:var(--b1);font-size:12.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase" data-i18n="br.mTag">Owned · Make-up</div>
				<h2 class="section-title" style="font-size:clamp(34px,4.4vw,58px);margin:12px 0 18px" data-i18n="br.mName">Mistory</h2>
				<p class="lead" style="max-width:480px" data-i18n="br.mDesc">A Vietnamese beauty brand celebrating the timeless essence of Vietnamese women.</p>
				<div class="chip" style="margin-top:22px" data-i18n="br.mBadge">The timeless beauty of Vietnam</div>
			</div>
			<div class="reveal d1" style="border-radius:24px;height:clamp(300px,36vw,420px);background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:clamp(30px,4vw,52px)">
				<img src="<?php echo esc_url( nonelab_asset( 'mistory-logo.png' ) ); ?>" alt="Mistory" style="max-width:70%;max-height:140px;object-fit:contain" />
			</div>
		</div>

		<!-- OWNED: LION BARTENDER -->
		<div class="feature" style="margin-top:clamp(56px,8vw,90px)">
			<div class="feat-text reveal">
				<div class="bc-tag" style="color:var(--b1);font-size:12.5px;font-weight:700;letter-spacing:.12em;text-transform:uppercase" data-i18n="br.lTag">Owned · Grooming</div>
				<h2 class="section-title" style="font-size:clamp(34px,4.4vw,58px);margin:12px 0 18px" data-i18n="br.lName">Lion Bartender</h2>
				<p class="lead" style="max-width:480px" data-i18n="br.lDesc">A bold men's grooming line developed in-house by Nonelab.</p>
				<div class="chip" style="margin-top:22px" data-i18n="br.lBadge">Developed in-house</div>
			</div>
			<div class="reveal d1" style="border-radius:24px;height:clamp(300px,36vw,420px);background:linear-gradient(135deg,#1a1206,#3a2a10);display:flex;align-items:center;justify-content:center;padding:clamp(30px,4vw,52px)">
				<img src="<?php echo esc_url( nonelab_asset( 'lion-logo.png' ) ); ?>" alt="Lion Bartender" style="max-width:72%;max-height:240px;object-fit:contain" />
			</div>
		</div>
	</div>
</section>

<!-- ===== DISTRIBUTED EXCLUSIVE ===== -->
<section class="section band-dark">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(40px,5vw,60px)">
			<div class="eyebrow" data-i18n="br.distEyebrow">Exclusive distribution</div>
			<h2 class="section-title" style="margin-top:16px;color:#fff" data-i18n="br.distTitle">Top Asian brands, exclusively in Vietnam.</h2>
			<p class="lead" style="margin-top:18px" data-i18n="br.distLead">We are the sole distributor of leading Chinese beauty brands in Vietnam.</p>
		</div>

		<div style="display:flex;flex-direction:column;gap:18px">
			<!-- Menow -->
			<div class="reveal dist-row">
				<div style="border-radius:14px;height:160px;background:#F4EEE6;display:flex;align-items:center;justify-content:center;padding:24px"><img src="<?php echo esc_url( nonelab_asset( 'menow-logo.png' ) ); ?>" alt="Menow" style="max-width:80%;max-height:104px;object-fit:contain" /></div>
				<div>
					<div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap"><h3 style="color:#fff" data-i18n="br.menowName">Menow</h3><span style="color:#FFB877;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase" data-i18n="br.menowTag">Exclusive · Make-up</span></div>
					<p style="color:rgba(255,255,255,.66);margin-top:10px;font-size:15.5px" data-i18n="br.menowDesc">China's most-loved makeup brand.</p>
				</div>
				<div style="display:flex;flex-direction:column;gap:14px">
					<div><div class="feature-num grad-text" style="font-size:30px"><span data-count="500000">500,000</span></div><div style="color:rgba(255,255,255,.5);font-size:13px" data-i18n="br.menowS1">products sold</div></div>
					<div style="color:rgba(255,255,255,.8);font-size:14px;font-weight:600" data-i18n="br.menowS2">Top 1 best-seller, H1 2025</div>
				</div>
			</div>
			<!-- Spenny -->
			<div class="reveal d1 dist-row">
				<div style="border-radius:14px;height:160px;background:linear-gradient(135deg,#5B57C9,#37A7C2);display:flex;align-items:center;justify-content:center;color:#fff;font-family:var(--disp);font-weight:700;font-size:24px;letter-spacing:-.02em">Spenny</div>
				<div>
					<div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap"><h3 style="color:#fff" data-i18n="br.spennyName">Spenny</h3><span style="color:#FFB877;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase" data-i18n="br.spennyTag">Exclusive distribution</span></div>
					<p style="color:rgba(255,255,255,.66);margin-top:10px;font-size:15.5px" data-i18n="br.spennyDesc">An exclusive partner brand distributed by Nonelab in Vietnam.</p>
				</div>
				<div style="display:flex;flex-direction:column;gap:14px">
					<div style="color:rgba(255,255,255,.8);font-size:14px;font-weight:600" data-i18n="br.spennyMeta">Exclusive in Vietnam</div>
				</div>
			</div>
			<!-- Online distribution -->
			<div class="reveal d2 dist-row">
				<div style="border-radius:14px;height:160px;background:var(--grad);display:flex;align-items:center;justify-content:center;color:#fff;font-family:var(--disp);font-weight:700;font-size:22px;letter-spacing:-.02em">Online</div>
				<div>
					<div style="display:flex;align-items:baseline;gap:12px;flex-wrap:wrap"><h3 style="color:#fff" data-i18n="br.onlineH">Online distribution</h3><span style="color:#FFB877;font-size:12px;font-weight:700;letter-spacing:.1em;text-transform:uppercase" data-i18n="br.onlineTag">E-commerce</span></div>
					<p style="color:rgba(255,255,255,.66);margin-top:10px;font-size:15.5px" data-i18n="br.onlineDesc">A dedicated online distribution engine across Vietnam's biggest e-commerce platforms, led by our pioneering presence on TikTok Shop.</p>
				</div>
				<div style="display:flex;flex-direction:column;gap:14px">
					<div><div class="feature-num grad-text" style="font-size:30px"><span data-count="3" data-suffix="M+">3M+</span></div><div style="color:rgba(255,255,255,.5);font-size:13px" data-i18n="br.onlineStat">reach every month</div></div>
					<div style="color:rgba(255,255,255,.8);font-size:14px;font-weight:600">TikTok Shop · Shopee · Lazada</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ===== EXPANSION ===== -->
<section class="section">
	<div class="wrap">
		<div style="max-width:820px">
			<div class="reveal">
				<div class="eyebrow" data-i18n="br.expEyebrow">Regional expansion</div>
				<h2 class="section-title" style="margin-top:16px;font-size:clamp(30px,3.6vw,48px)" data-i18n="br.expTitle">Beyond Vietnam — across Southeast Asia.</h2>
				<p class="lead" style="margin-top:18px;max-width:560px" data-i18n="br.expBody">We are expanding our brands to other Southeast Asian markets.</p>
				<div style="display:flex;gap:12px;margin-top:28px;flex-wrap:wrap">
					<span class="chip" data-i18n="br.m1">Vietnam</span>
					<span class="chip" data-i18n="br.m2">Indonesia</span>
					<span class="chip" data-i18n="br.m3">Philippines</span>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ===== NERMAN IN INDONESIA ===== -->
<section class="section band-dark">
	<div class="wrap">
		<div class="reveal" style="max-width:760px;margin-bottom:clamp(32px,5vw,52px)">
			<div class="eyebrow" data-i18n="br.idEyebrow">Nerman × Indonesia</div>
			<h2 class="section-title" style="color:#fff;margin-top:16px;font-size:clamp(30px,3.6vw,48px)" data-i18n="br.idTitle">Now available in Indonesia.</h2>
			<p class="lead" style="margin-top:18px;max-width:620px" data-i18n="br.idBody">Nerman is now on shelves across Indonesian retail — bringing its Hair &amp; Body 4-in-1 Wash and the signature cool sensation to a new generation of gentlemen.</p>
		</div>
		<div class="grid cols-2" style="max-width:680px">
			<div class="reveal" style="border-radius:18px;overflow:hidden;height:clamp(240px,32vw,360px)">
				<img src="<?php echo esc_url( nonelab_asset( 'nerman-id-retail.jpg' ) ); ?>" alt="Nerman retail display, Indonesia" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block" />
			</div>
			<div class="reveal d1" style="border-radius:18px;overflow:hidden;height:clamp(240px,32vw,360px)">
				<img src="<?php echo esc_url( nonelab_asset( 'nerman-id-booth.jpg' ) ); ?>" alt="Nerman booth, Indonesia" loading="lazy" style="width:100%;height:100%;object-fit:cover;display:block" />
			</div>
		</div>
		<div class="reveal d1" style="display:flex;gap:12px;margin-top:26px;flex-wrap:wrap">
			<span class="chip" data-i18n="br.idTag1">Hair &amp; Body 4-in-1 Wash</span>
			<span class="chip" data-i18n="br.idTag2">Experience the cool sensation</span>
		</div>
	</div>
</section>

<!-- ===== CTA ===== -->
<section class="section" style="padding-top:0">
	<div class="wrap">
		<div class="cta-band reveal">
			<div class="hero-orb" style="width:300px;height:300px;background:rgba(255,255,255,.14);top:-120px;right:-80px"></div>
			<div style="position:relative;z-index:2">
				<h2 class="section-title" style="max-width:760px;margin:0 auto" data-i18n="br.ctaT">Want your brand on our shelves?</h2>
				<p style="font-size:18px;max-width:540px;margin:20px auto 0;color:rgba(255,255,255,.9)" data-i18n="br.ctaB">Bring your brand to Vietnam and Southeast Asia.</p>
				<a class="btn" href="<?php echo esc_url( $contact_url ); ?>" style="background:#fff;color:var(--ink);margin-top:30px"><span data-i18n="br.ctaBtn">Partner with us</span><span class="arr">→</span></a>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
