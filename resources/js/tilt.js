// Cards that lean toward the mouse, with a light that follows it.
//   data-tilt="light|dark"  tilts the element (light = for white cards)
//   data-spot               only the light, no tilt (used for the stat tiles)
// Only for a real mouse on a laptop-size screen: phones and tablets get nothing, and
// neither do visitors who ask for reduced motion. It listens on the whole document, so
// cards that Livewire redraws keep working.
const MAX_TILT = 6; // degrees

export function initTilt() {
    const wanted = window.matchMedia('(hover: hover) and (pointer: fine) and (min-width: 1024px)').matches;
    const calm = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if (!wanted || calm) return;

    let current = null;

    function rest(el) {
        ['--rx', '--ry', '--mx', '--my'].forEach((name) => el.style.removeProperty(name));
        el.classList.remove('is-hot');
    }

    document.addEventListener('pointermove', (e) => {
        if (e.pointerType !== 'mouse') return;

        const el = e.target instanceof Element ? e.target.closest('[data-tilt], [data-spot]') : null;
        if (current && current !== el) rest(current);
        current = el;
        if (!el) return;

        const box = el.getBoundingClientRect();
        const x = (e.clientX - box.left) / box.width;
        const y = (e.clientY - box.top) / box.height;

        el.style.setProperty('--mx', x * 100 + '%');
        el.style.setProperty('--my', y * 100 + '%');
        if (el.hasAttribute('data-tilt')) {
            el.style.setProperty('--ry', (x - 0.5) * 2 * MAX_TILT + 'deg');
            el.style.setProperty('--rx', (0.5 - y) * 2 * MAX_TILT + 'deg');
        }
        el.classList.add('is-hot');
    }, { passive: true });

    document.documentElement.addEventListener('pointerleave', () => {
        if (current) rest(current);
        current = null;
    });
}
