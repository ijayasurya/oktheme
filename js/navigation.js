/**
 * Navigation functionality
 */
(function() {
	const mobileMenuToggle = document.querySelector('.mobile-menu-toggle');
	const mobileNavigation = document.querySelector('#mobile-navigation');
	
	if (mobileMenuToggle && mobileNavigation) {
		mobileMenuToggle.addEventListener('click', function() {
			const isExpanded = mobileMenuToggle.getAttribute('aria-expanded') === 'true';
			
			mobileMenuToggle.setAttribute('aria-expanded', !isExpanded);
			mobileNavigation.classList.toggle('hidden');
		});
	}
})();

