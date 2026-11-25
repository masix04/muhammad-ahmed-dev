export function initWorkspaceHero() {

    const workspace =
        document.getElementById('workspace');

    const inner =
        document.getElementById('workspace-inner');

    if (!workspace || !inner) return;

    const cards =
        [...document.querySelectorAll('.workspace-card')];

    let mouseX = 0;
    let mouseY = 0;

    // -------------------------
    // Mouse Parallax
    // -------------------------

    workspace.addEventListener('mousemove', e => {

        const rect =
            workspace.getBoundingClientRect();

        mouseX =
            (e.clientX - rect.left) /
            rect.width - .5;

        mouseY =
            (e.clientY - rect.top) /
            rect.height - .5;

    });

    // -------------------------
    // Hover Focus
    // -------------------------

    cards.forEach(card => {

        card.addEventListener('mouseenter', () => {

            cards.forEach(c => {

                if (c === card) {
                    c.classList.add('active');
                } else {
                    c.classList.add('dim');
                }

            });

        });

        card.addEventListener('mouseleave', () => {

            cards.forEach(c => {

                c.classList.remove('active');
                c.classList.remove('dim');

            });

        });

    });

    // -------------------------
    // Animate
    // -------------------------

    function animate(time) {

        const rx = mouseY * -10;
        const ry = mouseX * 10;

        inner.style.transform =
            `rotateX(${rx}deg)
             rotateY(${ry}deg)`;

        cards.forEach((card,index) => {

            const depth =
                Number(card.dataset.depth);

            const floatY =
                Math.sin(
                    time * 0.001 +
                    index
                ) * 12;

            const floatX =
                Math.cos(
                    time * 0.0007 +
                    index
                ) * 8;

            if (!card.classList.contains('active')) {

                card.style.transform =
                    `
                    translateX(${floatX}px)
                    translateY(${floatY}px)
                    translateZ(${depth}px)
                    `;

            }

        });

        if (running) {
            requestAnimationFrame(animate);
        }

    }

    // -------------------------
    // Run only while visible
    // -------------------------
    // The hero is hidden on small screens and scrolls out of view on every
    // screen, so don't spend CPU/battery animating it then. Visitors who ask
    // for reduced motion get one still frame instead.

    let running = false;

    const reduceMotion =
        window.matchMedia('(prefers-reduced-motion: reduce)').matches;

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

    }).observe(workspace);

}