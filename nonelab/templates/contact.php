<?php
/**
 * Template Name: Nonelab — Contact
 *
 * @package Nonelab
 */

get_header();
?>

<!-- ===== PAGE HERO ===== -->
<section class="section" style="padding-top:clamp(130px,16vh,180px);padding-bottom:clamp(20px,4vw,40px)">
	<div class="wrap">
		<div class="eyebrow reveal" data-i18n="co.eyebrow">Contact</div>
		<h1 class="display reveal d1" style="max-width:900px;margin-top:18px;font-size:clamp(40px,5vw,72px)" data-i18n="co.title">Let's build something beautiful together.</h1>
		<p class="lead reveal d2" style="max-width:600px;margin-top:24px" data-i18n="co.lead">Whether you're a brand, a retailer, or press — we'd love to hear from you.</p>
	</div>
</section>

<!-- ===== INFO + FORM ===== -->
<section class="section" style="padding-top:clamp(30px,4vw,50px)">
	<div class="wrap">
		<div style="display:grid;grid-template-columns:.85fr 1.15fr;gap:clamp(36px,6vw,80px);align-items:start" class="contact-grid">

			<!-- INFO -->
			<div class="reveal">
				<div class="eyebrow" data-i18n="co.infoEyebrow">Reach us</div>
				<div style="margin-top:28px;display:flex;flex-direction:column;gap:26px">
					<div>
						<div style="font-weight:700;font-family:var(--disp);font-size:20px" data-i18n="co.hnT">Hanoi</div>
						<div style="color:var(--muted);margin-top:4px" data-i18n="co.hnA">43 ngõ 100 Dịch Vọng Hậu, Cầu Giấy, Hà Nội, Việt Nam</div>
					</div>
					<div>
						<div style="font-weight:700;font-family:var(--disp);font-size:20px" data-i18n="co.emailT">Email</div>
						<a href="mailto:hello@nonelab.net" style="color:var(--b1);margin-top:4px;display:inline-block;font-weight:600" data-i18n="co.email">hello@nonelab.net</a>
					</div>
					<div>
						<div style="font-weight:700;font-family:var(--disp);font-size:20px" data-i18n="co.hotlineT">Hotline</div>
						<a href="tel:19004628" style="color:var(--b1);margin-top:4px;display:inline-block;font-weight:600" data-i18n="co.hotline">1900 4628</a>
					</div>
				</div>
			</div>

			<!-- FORM -->
			<div class="card reveal d1" style="padding:clamp(26px,3.4vw,44px)">
				<h3 data-i18n="co.formTitle">Partnership enquiry</h3>
				<form id="enquiry" style="margin-top:24px" novalidate>
					<div style="display:grid;grid-template-columns:1fr 1fr;gap:0 18px" class="form-two">
						<div class="form-field" data-for="name">
							<label data-i18n="co.fName">Full name</label>
							<input type="text" name="name" data-i18n-ph="co.fNameP" placeholder="Your name" />
							<span class="msg" data-i18n="co.errName">Please enter your name.</span>
						</div>
						<div class="form-field">
							<label data-i18n="co.fCompany">Company / brand</label>
							<input type="text" name="company" data-i18n-ph="co.fCompanyP" placeholder="Your company" />
							<span class="msg"></span>
						</div>
					</div>
					<div class="form-field" data-for="email">
						<label data-i18n="co.fEmail">Email</label>
						<input type="email" name="email" data-i18n-ph="co.fEmailP" placeholder="you@company.com" />
						<span class="msg" data-i18n="co.errEmail">Please enter a valid email.</span>
					</div>
					<div class="form-field form-select">
						<label data-i18n="co.fType">I'm enquiring about</label>
						<select name="type">
							<option data-i18n="co.t1">Brand distribution</option>
							<option data-i18n="co.t2">Retail partnership</option>
							<option data-i18n="co.t3">Press / media</option>
							<option data-i18n="co.t4">Something else</option>
						</select>
						<span class="msg"></span>
					</div>
					<div class="form-field" data-for="message">
						<label data-i18n="co.fMsg">Message</label>
						<textarea name="message" data-i18n-ph="co.fMsgP" placeholder="Tell us a little about your brand or enquiry…"></textarea>
						<span class="msg" data-i18n="co.errMsg">Please add a short message.</span>
					</div>
					<button type="submit" class="btn grad" style="width:100%;justify-content:center;margin-top:6px">
						<span class="btn-label" data-i18n="co.submit">Send enquiry</span><span class="arr">→</span>
					</button>
				</form>

				<div id="success" class="form-success" style="display:none">
					<div class="check"><svg viewBox="0 0 24 24" fill="none"><path d="M4 12.5l5 5L20 6.5" stroke="#fff" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
					<h3 data-i18n="co.okTitle">Thank you — message sent.</h3>
					<p class="lead" style="margin-top:10px" data-i18n="co.okBody">Our team will get back to you within 1–2 business days.</p>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
