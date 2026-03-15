import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

function initRevealAnimations() {
    const items = document.querySelectorAll('.reveal-up');
    if (!items.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
    });

    items.forEach((item) => observer.observe(item));
}

function initEventSlider() {
    const root = document.querySelector('[data-event-slider]');
    if (!root) return;

    const slides = Array.from(root.querySelectorAll('[data-event-slide]'));
    const thumbs = Array.from(root.querySelectorAll('[data-event-thumb]'));
    const prevBtn = root.querySelector('[data-event-prev]');
    const nextBtn = root.querySelector('[data-event-next]');

    if (!slides.length) return;

    let index = 0;

    function show(newIndex) {
        slides[index].classList.add('hidden');
        if (thumbs[index]) thumbs[index].classList.remove('is-active');

        index = (newIndex + slides.length) % slides.length;

        slides[index].classList.remove('hidden');
        if (thumbs[index]) thumbs[index].classList.add('is-active');
    }

    prevBtn?.addEventListener('click', () => show(index - 1));
    nextBtn?.addEventListener('click', () => show(index + 1));

    thumbs.forEach((thumb, thumbIndex) => {
        thumb.addEventListener('click', () => show(thumbIndex));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initRevealAnimations();
    initEventSlider();
});