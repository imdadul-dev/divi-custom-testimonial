/**
 * Media Testimonial Slider — Swiper init, lightbox, accessibility helpers.
 *
 * @package DiviCustomTestimonial
 */
(function () {
	'use strict';

	/**
	 * Parse JSON from data attribute safely.
	 *
	 * @param {string} raw Raw JSON string.
	 * @return {Object|null}
	 */
	function parseConfig(raw) {
		if (!raw) {
			return null;
		}
		try {
			return JSON.parse(raw);
		} catch (e) {
			return null;
		}
	}

	/**
	 * Ensure a single lightbox exists in the document.
	 *
	 * @return {HTMLElement}
	 */
	function getStrings() {
		return window.dctMtsL10n || {};
	}

	function getOrCreateLightbox() {
		var existing = document.getElementById('dct-mts-lightbox-root');
		if (existing) {
			return existing;
		}

		var l10n = getStrings();
		var videoLabel = l10n.videoLabel || 'Video';
		var closeLabel = l10n.closeLabel || 'Close';

		var wrap = document.createElement('div');
		wrap.id = 'dct-mts-lightbox-root';
		wrap.className = 'dct-mts-lightbox';
		wrap.setAttribute('hidden', 'hidden');
		wrap.innerHTML =
			'<div class="dct-mts-lightbox__backdrop" data-dct-lightbox-close tabindex="-1"></div>' +
			'<div class="dct-mts-lightbox__dialog" role="dialog" aria-modal="true" aria-label="' +
			String(videoLabel).replace(/"/g, '&quot;') +
			'">' +
			'<button type="button" class="dct-mts-lightbox__close" data-dct-lightbox-close aria-label="' +
			String(closeLabel).replace(/"/g, '&quot;') +
			'">&times;</button>' +
			'<div class="dct-mts-lightbox__inner"></div>' +
			'</div>';

		document.body.appendChild(wrap);
		return wrap;
	}

	/**
	 * Open lightbox with embed HTML.
	 *
	 * @param {string} html HTML from oEmbed / video tag.
	 */
	function openLightbox(html) {
		var box = getOrCreateLightbox();
		var inner = box.querySelector('.dct-mts-lightbox__inner');
		if (!inner) {
			return;
		}

		inner.innerHTML = html;
		box.removeAttribute('hidden');

		var closeBtn = box.querySelector('.dct-mts-lightbox__close');
		if (closeBtn) {
			closeBtn.focus();
		}

		document.body.style.overflow = 'hidden';
	}

	/**
	 * Close lightbox and clear iframe sources.
	 */
	function closeLightbox() {
		var box = document.getElementById('dct-mts-lightbox-root');
		if (!box || box.hasAttribute('hidden')) {
			return;
		}

		var inner = box.querySelector('.dct-mts-lightbox__inner');
		if (inner) {
			inner.querySelectorAll('iframe').forEach(function (frame) {
				frame.setAttribute('src', '');
			});
			inner.innerHTML = '';
		}

		box.setAttribute('hidden', 'hidden');
		document.body.style.overflow = '';
	}

	var lightboxDocBound = false;

	/**
	 * Bind document-level lightbox close once.
	 */
	function bindLightboxDocumentOnce() {
		if (lightboxDocBound) {
			return;
		}
		lightboxDocBound = true;

		document.addEventListener('click', function (e) {
			if (e.target.matches('[data-dct-lightbox-close]')) {
				closeLightbox();
			}
		});

		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape') {
				closeLightbox();
			}
		});
	}

	/**
	 * Bind lightbox triggers inside a module root.
	 *
	 * @param {HTMLElement} root Module element.
	 */
	function bindLightbox(root) {
		var lightboxEnabled = root.getAttribute('data-dct-video-lightbox') === '1';

		bindLightboxDocumentOnce();

		root.addEventListener('click', function (e) {
			var btn = e.target.closest('.dct-mts__play');
			if (!btn || !root.contains(btn)) {
				return;
			}

			if (!lightboxEnabled) {
				return;
			}

			var media = btn.closest('.dct-mts__media-inner--video');
			if (!media) {
				return;
			}

			var store = media.querySelector('.dct-mts__embed-store');
			if (!store) {
				return;
			}

			var html = store.innerHTML.trim();
			if (!html) {
				return;
			}

			e.preventDefault();
			openLightbox(html);
		});
	}

	/**
	 * Initialize Swiper instances.
	 */
	function initSwipers() {
		if (typeof Swiper === 'undefined') {
			return;
		}

		var nodes = document.querySelectorAll('.dct-mts__swiper[data-swiper-config]');

		nodes.forEach(function (el) {
			if (el.getAttribute('data-dct-swiper-ready')) {
				return;
			}

			var cfg = parseConfig(el.getAttribute('data-swiper-config'));
			if (!cfg) {
				return;
			}

			// eslint-disable-next-line no-new
			new Swiper(el, cfg);
			el.setAttribute('data-dct-swiper-ready', '1');
		});
	}

	/**
	 * Boot.
	 */
	function boot() {
		initSwipers();

		document.querySelectorAll('.dct-mts').forEach(function (root) {
			bindLightbox(root);
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}

	// Divi VB / dynamic load.
	if (window.jQuery && window.jQuery(document).on) {
		window.jQuery(window).on('load', function () {
			initSwipers();
		});
	}
})();
