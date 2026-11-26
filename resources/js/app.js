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

// ── Scroll spy ──────────────────────────────────────────────────────────────
// Marks the nav link of the section being read, and slides an underline to it.
// Links look like "/#projects"; on pages without those sections (the blog) nothing happens.
function initScrollSpy() {
    const links = [...document.querySelectorAll('[data-spy-link]')]
        .map((a) => ({ a, id: (a.getAttribute('href') || '').split('#')[1] }))
        .filter((l) => l.id);
    const sections = [...new Set(links.map((l) => l.id))]
        .map((id) => document.getElementById(id))
        .filter(Boolean);
    if (!sections.length) return;

    const bar = document.querySelector('.nav-underline');
    const box = bar ? bar.parentElement : null;
    let current = null;

    function update() {
        // The section that has passed about a third of the way up the screen
        const line = window.innerHeight * 0.35;
        let active = null;
        sections.forEach((el) => {
            if (el.getBoundingClientRect().top <= line) active = el.id;
        });

        // Slide the underline under the active link (desktop bar only)
        if (bar && box) {
            const target = links.find((l) => l.id === active && box.contains(l.a));
            if (target) {
                bar.style.setProperty('--x', target.a.offsetLeft + 'px');
                bar.style.setProperty('--w', target.a.offsetWidth + 'px');
            }
            box.classList.toggle('has-active', Boolean(target));
        }

        if (active === current) return;
        current = active;
        links.forEach((l) => {
            const on = l.id === active;
            l.a.classList.toggle('is-active', on);
            if (on) l.a.setAttribute('aria-current', 'location');
            else l.a.removeAttribute('aria-current');
        });
    }

    let waiting = false;
    const onScroll = () => {
        if (waiting) return;
        waiting = true;
        requestAnimationFrame(() => { waiting = false; update(); });
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', update);
    window.addEventListener('load', update); // fonts can change the link widths
    update();
}

document.addEventListener('DOMContentLoaded', () => {
    initWorkspaceHero();
    initReveal();
    initScrollSpy();
});
