(function () {
	'use strict';

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
	});
})();
