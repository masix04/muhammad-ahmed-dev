// Alpine and Livewire are loaded by @livewireScripts, so nothing to import here.
import { initWorkspaceHero } from './workspace-hero';

// ── Scroll reveal ───────────────────────────────────────────────────────────
// Elements with the class "reveal" fade up once as they scroll into view.
function initReveal() {
    const items = [...document.querySelectorAll('.reveal')];
    if (!items.length) return;

    if (!('IntersectionObserver' in window)) {
        items.forEach((el) => el.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -6% 0px' });

    items.forEach((el) => observer.observe(el));
}

document.addEventListener('DOMContentLoaded', () => {
    initWorkspaceHero();
    initReveal();
});
