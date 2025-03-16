import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;


Alpine.start();
document.addEventListener('DOMContentLoaded', function () {
    const nav = document.getElementById('main-nav');
    const hero = document.getElementById('hero');
    const toggleElements = document.querySelectorAll('.toggle-color');
    const menuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const hamburgerIcon = document.getElementById('hamburger-icon');
    const closeIcon = document.getElementById('close-icon');
    const logoWhite = document.getElementById('logo-white');
    const logoBlack = document.getElementById('logo-black');

    // Mobile menu toggle (ako postoje elementi)
    if (menuButton && mobileMenu && hamburgerIcon && closeIcon) {
        menuButton.addEventListener('click', function () {
            const isOpen = mobileMenu.classList.toggle('hidden');
            hamburgerIcon.classList.toggle('hidden', !isOpen);
            closeIcon.classList.toggle('hidden', isOpen);
        });
    }

    // Nav color change on scroll - proveravamo da li postoji hero
    function updateNavColor() {
        if (!hero) return; // Ako hero ne postoji, prekidamo funkciju
        const offset = 20;
        const shouldChangeColor = window.scrollY > (hero.offsetHeight - offset);

        if (logoWhite && logoBlack) {
            logoWhite.classList.toggle('hidden', shouldChangeColor);
            logoBlack.classList.toggle('hidden', !shouldChangeColor);
        }

        toggleElements.forEach(el => {
            el.classList.toggle('text-white', !shouldChangeColor);
            el.classList.toggle('text-black', shouldChangeColor);
        });
    }

    window.addEventListener('scroll', updateNavColor);
    updateNavColor();

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        if (menuButton && mobileMenu && !menuButton.contains(event.target) && !mobileMenu.contains(event.target)) {
            mobileMenu.classList.add('hidden');
            if (hamburgerIcon) hamburgerIcon.classList.remove('hidden');
            if (closeIcon) closeIcon.classList.add('hidden');
        }
    });
});

