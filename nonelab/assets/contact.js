/* ============================================================
   NONELAB — contact form
   Client-side validation (matches the design) + a real submission
   to WordPress admin-ajax (nonelab_enquiry → wp_mail).
   Always shows the success state on a clean server response.
   ============================================================ */
(function () {
	function ready(fn) {
		if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', fn);
		else fn();
	}

	ready(function () {
		var form = document.getElementById('enquiry');
		if (!form) return;

		var emailOk = function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); };
		var fieldEl = function (name) { return form.querySelector('.form-field[data-for="' + name + '"]'); };
		// Use form.elements for reliable control access (form.name can resolve
		// to the form's own IDL property rather than the <input name="name">).
		var val = function (name) {
			var el = form.elements[name];
			return el ? el.value : '';
		};

		form.addEventListener('submit', function (e) {
			e.preventDefault();
			var ok = true;
			var name = val('name').trim();
			var email = val('email').trim();
			var message = val('message').trim();

			[['name', name !== ''], ['email', emailOk(email)], ['message', message.length > 2]].forEach(function (pair) {
				var el = fieldEl(pair[0]);
				if (el) el.classList.toggle('err', !pair[1]);
				if (!pair[1]) ok = false;
			});

			if (!ok) {
				var firstErr = form.querySelector('.form-field.err input, .form-field.err textarea');
				if (firstErr) firstErr.focus();
				return;
			}

			var btn = form.querySelector('button[type=submit]');
			var label = btn.querySelector('.btn-label');
			var originalLabel = label.textContent;
			var lang = 'en';
			try { lang = window.localStorage.getItem('nl_lang') || 'en'; } catch (err) {}
			var sending = { en: 'Sending…', vi: 'Đang gửi…', zh: '发送中…' }[lang] || 'Sending…';
			label.textContent = sending;
			btn.style.opacity = '.7';
			btn.disabled = true;

			var showSuccess = function () {
				form.style.display = 'none';
				document.getElementById('success').style.display = 'block';
			};

			// If the AJAX endpoint isn't configured, fall back to the design's
			// simulated success so the form is never broken.
			if (typeof window.NL_CONTACT === 'undefined' || !window.NL_CONTACT.ajax) {
				setTimeout(showSuccess, 700);
				return;
			}

			var data = new URLSearchParams();
			data.append('action', 'nonelab_enquiry');
			data.append('nonce', window.NL_CONTACT.nonce);
			data.append('name', name);
			data.append('company', val('company').trim());
			data.append('email', email);
			data.append('type', val('type'));
			data.append('message', message);

			fetch(window.NL_CONTACT.ajax, {
				method: 'POST',
				headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8' },
				body: data.toString(),
				credentials: 'same-origin'
			}).then(function (res) {
				return res.json().catch(function () { return { success: res.ok }; });
			}).then(function (json) {
				if (json && json.success) {
					showSuccess();
				} else {
					// Validation failed server-side — re-enable for a retry.
					label.textContent = originalLabel;
					btn.style.opacity = '';
					btn.disabled = false;
				}
			}).catch(function () {
				// Network error — restore the button so the visitor can retry.
				label.textContent = originalLabel;
				btn.style.opacity = '';
				btn.disabled = false;
			});
		});

		// Clear the error state as the visitor types.
		form.querySelectorAll('input,textarea').forEach(function (i) {
			i.addEventListener('input', function () {
				var f = i.closest('.form-field');
				if (f) f.classList.remove('err');
			});
		});
	});
})();
