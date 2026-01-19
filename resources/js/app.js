import './bootstrap';

// Accessible burger toggle: toggles .active on .burger and .mobile-menu,
// updates aria-hidden and supports keyboard (Enter/Space).
document.addEventListener('DOMContentLoaded', function () {
    const burger = document.querySelector('.burger');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (!burger || !mobileMenu) return;

    function toggleMenu() {
        const isActive = burger.classList.toggle('active');
        mobileMenu.classList.toggle('active', isActive);
        mobileMenu.setAttribute('aria-hidden', String(!isActive));

        if (isActive) {
            // Move focus into the menu for keyboard users
            const firstLink = mobileMenu.querySelector('a, button');
            if (firstLink) firstLink.focus();
        } else {
            // return focus to burger button
            burger.focus();
        }
    }

    burger.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleMenu();
    });

    // keyboard support: Enter or Space should toggle
    burger.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            toggleMenu();
        }
    });

    // close menu when clicking outside
    document.addEventListener('click', function (e) {
        if (!burger.contains(e.target) && !mobileMenu.contains(e.target)) {
            burger.classList.remove('active');
            mobileMenu.classList.remove('active');
            mobileMenu.setAttribute('aria-hidden', 'true');
        }
    });

    // close menu on Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            burger.classList.remove('active');
            mobileMenu.classList.remove('active');
            mobileMenu.setAttribute('aria-hidden', 'true');
            burger.focus();
        }
    });
});
