/**
 * Slider: sync slide widths to viewport and handle prev/next.
 */
(function () {
	'use strict';

	function initSlider(root) {
		var viewport = root.querySelector('.dct-viewport');
		var track = root.querySelector('.dct-track');
		var slides = root.querySelectorAll('.dct-slide');
		var prev = root.querySelector('.dct-nav--prev');
		var next = root.querySelector('.dct-nav--next');
		var total = slides.length;

		if (!viewport || !track || total === 0) {
			return;
		}

		var idx = 0;

		function slideWidth() {
			return viewport.getBoundingClientRect().width;
		}

		function applyLayout() {
			var w = slideWidth();
			if (w <= 0) {
				return;
			}
			for (var i = 0; i < slides.length; i++) {
				slides[i].style.flexBasis = w + 'px';
				slides[i].style.minWidth = w + 'px';
				slides[i].style.maxWidth = w + 'px';
			}
			go(idx, false);
		}

		function getTransitionMs() {
			var ms = 450;
			try {
				var raw = window
					.getComputedStyle(root)
					.getPropertyValue('--dct-slide-ms')
					.trim();
				var n = parseFloat(raw);
				if (!isNaN(n)) {
					ms = n;
				}
			} catch (e) {
				ms = 450;
			}
			var reduce =
				window.matchMedia &&
				window.matchMedia('(prefers-reduced-motion: reduce)').matches;
			return reduce ? 0 : ms;
		}

		function go(nextIndex, animate) {
			var w = slideWidth();
			if (w <= 0) {
				return;
			}
			if (total > 1) {
				idx = (nextIndex % total + total) % total;
			} else {
				idx = 0;
			}
			var offset = -(idx * w);
			var dur = getTransitionMs();
			if (animate === false) {
				track.style.transition = 'none';
			} else if (dur <= 0) {
				track.style.transition = 'none';
			} else {
				track.style.transition = 'transform ' + dur + 'ms ease';
			}
			track.style.transform = 'translate3d(' + offset + 'px, 0, 0)';
		}

		if (total < 2) {
			track.style.transform = 'translate3d(0, 0, 0)';
			return;
		}

		if (prev) {
			prev.addEventListener('click', function () {
				go(idx - 1, true);
			});
		}
		if (next) {
			next.addEventListener('click', function () {
				go(idx + 1, true);
			});
		}

		var resizeTimer;
		window.addEventListener(
			'resize',
			function () {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(function () {
					applyLayout();
				}, 100);
			},
			{ passive: true }
		);

		if (window.ResizeObserver) {
			var ro = new ResizeObserver(function () {
				applyLayout();
			});
			ro.observe(viewport);
		}

		applyLayout();
	}

	function boot() {
		document.querySelectorAll('[data-dct-slider]').forEach(initSlider);
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', boot);
	} else {
		boot();
	}
})();
