/**
 * Lion Bartender — front-end interactions.
 * Vanilla JS, no dependencies.
 */
(function () {
	'use strict';

	document.addEventListener('DOMContentLoaded', function () {
		var header = document.getElementById('lb-header');
		var burger = document.getElementById('lb-burger');
		var nav = document.getElementById('lb-nav');

		// Sticky header background on scroll.
		function onScroll() {
			if (!header) return;
			if (window.scrollY > 40) {
				header.classList.add('is-stuck');
			} else {
				header.classList.remove('is-stuck');
			}
		}
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();

		// Mobile menu toggle.
		if (burger && nav) {
			burger.addEventListener('click', function () {
				var open = nav.classList.toggle('is-open');
				burger.setAttribute('aria-expanded', open ? 'true' : 'false');
			});

			// Close menu when a link is clicked.
			nav.addEventListener('click', function (e) {
				if (e.target.tagName === 'A') {
					nav.classList.remove('is-open');
					burger.setAttribute('aria-expanded', 'false');
				}
			});
		}

		// Smooth-scroll for in-page anchors accounting for fixed header.
		document.querySelectorAll('a[href^="#"]').forEach(function (link) {
			link.addEventListener('click', function (e) {
				var id = link.getAttribute('href');
				if (id.length < 2) return;
				var target = document.querySelector(id);
				if (target) {
					e.preventDefault();
					var top = target.getBoundingClientRect().top + window.scrollY - 70;
					window.scrollTo({ top: top, behavior: 'smooth' });
				}
			});
		});
	});
})();
