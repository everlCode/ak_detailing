// Standalone burger script (fallback when Vite isn't running)
// Based on resources/js/app.js but without module imports
(function () {
    // Accessible burger toggle: toggles .active on .burger and .mobile-menu,
    // updates aria-hidden and supports keyboard (Enter/Space).
    document.addEventListener('DOMContentLoaded', function () {
        const burger = document.querySelector('.burger');
        const mobileMenu = document.querySelector('.mobile-menu');
        const closeBtn = document.querySelector('.mobile-menu__close');

        if (!burger || !mobileMenu) return;

        function setBodyScroll(disabled) {
            if (disabled) {
                document.body.classList.add('no-scroll');
            } else {
                document.body.classList.remove('no-scroll');
            }
        }

        function openMenu() {
            burger.classList.add('active');
            mobileMenu.classList.add('active');
            mobileMenu.setAttribute('aria-hidden', 'false');
            setBodyScroll(true);
            // focus first focusable element
            const firstLink = mobileMenu.querySelector('a, button');
            if (firstLink) firstLink.focus();
        }

        function closeMenu() {
            burger.classList.remove('active');
            mobileMenu.classList.remove('active');
            mobileMenu.setAttribute('aria-hidden', 'true');
            setBodyScroll(false);
            burger.focus();
        }

        function toggleMenu() {
            if (mobileMenu.classList.contains('active')) closeMenu(); else openMenu();
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
            if (!mobileMenu.classList.contains('active')) return;
            if (!burger.contains(e.target) && !mobileMenu.contains(e.target)) {
                closeMenu();
            }
        });

        // close menu on Escape
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeMenu();
            }
        });

        // close button handler
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                closeMenu();
            });
        }

        // close when clicking a link inside menu
        mobileMenu.addEventListener('click', function (e) {
            const target = e.target;
            if (target.tagName === 'A' || target.tagName === 'BUTTON') {
                // allow navigation, then close
                closeMenu();
            }
        });

    });
})();
