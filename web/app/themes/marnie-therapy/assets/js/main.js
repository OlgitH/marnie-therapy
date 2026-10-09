(function () {
	'use strict';

	// Keep --header-offset in sync with the real sticky header height so
	// anchor scrolling lands flush against it at every width.
	var siteHeader = document.querySelector('.site-header');
	var syncHeaderOffset = function () {};

	if (siteHeader) {
		syncHeaderOffset = function () {
			document.documentElement.style.setProperty(
				'--header-offset',
				siteHeader.getBoundingClientRect().height + 'px'
			);
		};

		syncHeaderOffset();
		window.addEventListener('resize', syncHeaderOffset);

		if (window.ResizeObserver) {
			new ResizeObserver(syncHeaderOffset).observe(siteHeader);
		}
	}

	// In-page links: scroll so the header's bottom edge meets the target's
	// top edge, then re-check once scrolling ends. Late layout changes
	// (images, fonts) or an interrupted smooth scroll can otherwise leave
	// the page short of, or past, the section.
	var reduceMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

	var targetTop = function (target) {
		return target.getBoundingClientRect().top + window.pageYOffset - siteHeader.getBoundingClientRect().height;
	};

	// Wait until the scroll position has stopped changing (scrollend is not
	// supported everywhere, and a fixed timeout can fire mid-scroll on a
	// long smooth scroll), then correct any remaining difference.
	var settle = function (target, tries) {
		var last = window.pageYOffset;
		var still = 0;
		var frames = 0;

		var tick = function () {
			frames++;
			var now = window.pageYOffset;
			still = now === last ? still + 1 : 0;
			last = now;

			// Stopped for ~10 frames, or gave up after ~3 seconds.
			if (still < 10 && frames < 180) {
				window.requestAnimationFrame(tick);
				return;
			}

			if (tries > 0 && Math.abs(targetTop(target) - now) > 1) {
				window.scrollTo({ top: targetTop(target), behavior: 'auto' });
				settle(target, tries - 1);
			}
		};

		window.requestAnimationFrame(tick);
	};

	if (siteHeader) {
		document.addEventListener('click', function (event) {
			var link = event.target.closest && event.target.closest('a[href^="#"]');
			var id = link && link.getAttribute('href').slice(1);
			var target = id && document.getElementById(id);

			if (!target || event.defaultPrevented) {
				return;
			}

			event.preventDefault();
			syncHeaderOffset();
			window.scrollTo({ top: targetTop(target), behavior: reduceMotion ? 'auto' : 'smooth' });
			settle(target, 3);

			if (window.history && history.pushState) {
				history.pushState(null, '', '#' + id);
			}
		});
	}

	// Mobile navigation toggle.
	var toggle = document.querySelector('.nav-toggle');
	var nav = document.getElementById('primary-navigation');

	if (toggle && nav) {
		toggle.addEventListener('click', function () {
			var isOpen = nav.classList.toggle('is-open');
			toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
		});

		// Close the mobile menu after choosing a link.
		nav.addEventListener('click', function (event) {
			if (event.target.tagName === 'A' && nav.classList.contains('is-open')) {
				nav.classList.remove('is-open');
				toggle.setAttribute('aria-expanded', 'false');
				// The open menu makes the header taller. Re-measure now that
				// it is closed, before the browser resolves the anchor
				// scroll, or the page stops short by the menu's height.
				syncHeaderOffset();
			}
		});
	}

	// Accessible FAQ accordion: answers are visible without JS; once JS
	// runs, they collapse and each trigger toggles aria-expanded + hidden.
	var faqLists = document.querySelectorAll('[data-faq-list]');

	faqLists.forEach(function (list) {
		var triggers = list.querySelectorAll('.faq-item__trigger');

		triggers.forEach(function (trigger) {
			var panel = document.getElementById(trigger.getAttribute('aria-controls'));
			if (!panel) {
				return;
			}
			panel.hidden = true;

			trigger.addEventListener('click', function () {
				var expanded = trigger.getAttribute('aria-expanded') === 'true';
				trigger.setAttribute('aria-expanded', expanded ? 'false' : 'true');
				panel.hidden = expanded;
			});
		});

		// Size the photo collage to the collapsed list, so opening an answer
		// doesn't stretch the photos (or shift anything else).
		var faq = list.closest('.faq');
		if (faq && faq.querySelector('.faq__photos')) {
			var syncFaqPhotos = function () {
				var height = 0;
				list.querySelectorAll('.faq-item > h3').forEach(function (heading) {
					height += heading.offsetHeight + 1; // + the item's bottom border
				});
				faq.style.setProperty('--faq-photos-height', height + 1 + 'px');
			};
			syncFaqPhotos();
			window.addEventListener('resize', syncFaqPhotos);
			if (document.fonts && document.fonts.ready) {
				document.fonts.ready.then(syncFaqPhotos);
			}
		}
	});
})();
