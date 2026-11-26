// The hero's floating project cards (laptops and up).
//   - the whole stack leans a few degrees toward the mouse
//   - each card sits at its own depth, floats gently and tilts toward the cursor
//   - the glows behind move the other way, so the scene has layers
// It runs only while the hero is on screen, and visitors who ask for reduced motion
// get one still frame.
export function initWorkspaceHero() {
    const hero = document.getElementById('hero');
    const workspace = document.getElementById('workspace');
    const inner = document.getElementById('workspace-inner');
    if (!hero || !workspace || !inner) return;

    const cards = [...document.querySelectorAll('.workspace-card')];
    const glows = [...document.querySelectorAll('.hero-glow')];
    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const TILT = 7; // degrees a card can lean
    const mouse = { x: 0, y: 0, cx: 0, cy: 0, inside: false }; // x, y: -0.5 to 0.5 across the hero
    const smooth = { x: 0, y: 0 };
    const lean = cards.map(() => ({ rx: 0, ry: 0 }));
    const clamp = (n) => Math.max(-1, Math.min(1, n));
    let running = false;

    if (!reduceMotion) {
        hero.addEventListener('mousemove', (e) => {
            const r = hero.getBoundingClientRect();
            mouse.x = (e.clientX - r.left) / r.width - 0.5;
            mouse.y = (e.clientY - r.top) / r.height - 0.5;
            mouse.cx = e.clientX;
            mouse.cy = e.clientY;
            mouse.inside = true;
        });
        hero.addEventListener('mouseleave', () => {
            mouse.x = 0;
            mouse.y = 0;
            mouse.inside = false;
        });
    }

    // Hover focus: the card under the mouse comes forward, the others fade back
    cards.forEach((card) => {
        card.addEventListener('mouseenter', () => {
            cards.forEach((c) => c.classList.toggle('active', c === card));
            cards.forEach((c) => c.classList.toggle('dim', c !== card));
        });
        card.addEventListener('mouseleave', () => {
            cards.forEach((c) => c.classList.remove('active', 'dim'));
        });
    });

    function animate(time) {
        smooth.x += (mouse.x - smooth.x) * 0.08;
        smooth.y += (mouse.y - smooth.y) * 0.08;

        inner.style.transform = `rotateX(${smooth.y * -6}deg) rotateY(${smooth.x * 6}deg)`;

        glows.forEach((glow, i) => {
            const pull = 30 + i * 22;
            glow.style.translate = `${smooth.x * -pull}px ${smooth.y * -pull}px`;
        });

        // Read the layout once, then write
        const box = mouse.inside ? workspace.getBoundingClientRect() : null;

        cards.forEach((card, i) => {
            const depth = Number(card.dataset.depth) || 0;
            const floatY = Math.sin(time * 0.001 + i) * 12;
            const floatX = Math.cos(time * 0.0007 + i) * 8;

            let targetX = 0;
            let targetY = 0;
            if (box) {
                // Cursor position inside the workspace, and the card's centre in the same space
                const lx = mouse.cx - box.left;
                const ly = mouse.cy - box.top;
                const centreX = card.offsetLeft + card.offsetWidth / 2;
                const centreY = card.offsetTop + card.offsetHeight / 2;
                targetY = clamp((lx - centreX) / (box.width * 0.5)) * TILT;
                targetX = clamp((ly - centreY) / (box.height * 0.5)) * -TILT;
                card.style.setProperty('--mx', ((lx - card.offsetLeft) / card.offsetWidth) * 100 + '%');
                card.style.setProperty('--my', ((ly - card.offsetTop) / card.offsetHeight) * 100 + '%');
            }

            lean[i].rx += (targetX - lean[i].rx) * 0.12;
            lean[i].ry += (targetY - lean[i].ry) * 0.12;

            const lift = card.classList.contains('active') ? 70 : 0;
            card.style.transform =
                `translate3d(${floatX}px, ${floatY}px, ${depth + lift}px) ` +
                `rotateX(${lean[i].rx}deg) rotateY(${lean[i].ry}deg)`;
        });

        if (running) requestAnimationFrame(animate);
    }

    if (reduceMotion || !('IntersectionObserver' in window)) {
        animate(0);
        return;
    }

    new IntersectionObserver(([entry]) => {
        if (entry.isIntersecting && !running) {
            running = true;
            requestAnimationFrame(animate);
        } else if (!entry.isIntersecting) {
            running = false;
        }
    }).observe(workspace); // hidden below laptop width, so it never runs on phones and tablets
}
