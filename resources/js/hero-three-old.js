import * as THREE from 'three';

export function initHeroThree(canvasId) {
    const canvas = document.getElementById(canvasId);
    if (!canvas) return;

    // ── Renderer ────────────────────────────────────────────────────────────
    const renderer = new THREE.WebGLRenderer({ canvas, alpha: true, antialias: true });
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);

    // ── Scene / Camera ───────────────────────────────────────────────────────
    const scene  = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(55, 1, 0.1, 1000);
    camera.position.z = 6;

    // ── Particles ────────────────────────────────────────────────────────────
    const COUNT   = 200;
    const SPREAD  = 12;
    const positions  = new Float32Array(COUNT * 3);
    const velocities = [];

    for (let i = 0; i < COUNT; i++) {
        positions[i * 3]     = (Math.random() - 0.5) * SPREAD;
        positions[i * 3 + 1] = (Math.random() - 0.5) * SPREAD * 0.55;
        positions[i * 3 + 2] = (Math.random() - 0.5) * 2;
        velocities.push({
            x: (Math.random() - 0.5) * 0.003,
            y: (Math.random() - 0.5) * 0.003,
        });
    }

    const ptGeo = new THREE.BufferGeometry();
    ptGeo.setAttribute('position', new THREE.BufferAttribute(positions, 3));

    const ptMat = new THREE.PointsMaterial({
        color: 0xb8b4ae,   // warm stone-300
        size: 0.032,
        transparent: true,
        opacity: 0.75,
        sizeAttenuation: true,
    });

    const points = new THREE.Points(ptGeo, ptMat);
    scene.add(points);

    // ── Connection lines ─────────────────────────────────────────────────────
    const MAX_LINES    = COUNT * 5;
    const lineArr      = new Float32Array(MAX_LINES * 6);
    const lineGeo      = new THREE.BufferGeometry();
    lineGeo.setAttribute('position', new THREE.BufferAttribute(lineArr, 3));

    const lineMat = new THREE.LineBasicMaterial({
        color: 0xdedad6,
        transparent: true,
        opacity: 0.3,
    });

    const lineSegments = new THREE.LineSegments(lineGeo, lineMat);
    scene.add(lineSegments);

    // ── Mouse parallax ────────────────────────────────────────────────────────
    let targetX = 0, targetY = 0;
    window.addEventListener('mousemove', (e) => {
        targetX = (e.clientX / window.innerWidth  - 0.5) * 0.7;
        targetY = (e.clientY / window.innerHeight - 0.5) * 0.4;
    });

    // ── Resize handler ───────────────────────────────────────────────────────
    function resize() {
        const w = canvas.offsetWidth;
        const h = canvas.offsetHeight;
        renderer.setSize(w, h, false);
        camera.aspect = w / h;
        camera.updateProjectionMatrix();
    }
    resize();
    window.addEventListener('resize', resize);

    // ── Animate ───────────────────────────────────────────────────────────────
    const CONNECT_DIST = 1.8;
    let frame = 0;

    function animate() {
        requestAnimationFrame(animate);
        frame++;

        const pos = ptGeo.attributes.position.array;

        // Drift particles
        for (let i = 0; i < COUNT; i++) {
            pos[i * 3]     += velocities[i].x;
            pos[i * 3 + 1] += velocities[i].y;
            if (Math.abs(pos[i * 3])     > SPREAD / 2)      velocities[i].x *= -1;
            if (Math.abs(pos[i * 3 + 1]) > SPREAD * 0.275)  velocities[i].y *= -1;
        }
        ptGeo.attributes.position.needsUpdate = true;

        // Rebuild lines every 2 frames
        if (frame % 2 === 0) {
            let lc = 0;
            const lp = lineGeo.attributes.position.array;
            for (let i = 0; i < COUNT; i++) {
                for (let j = i + 1; j < COUNT && lc < MAX_LINES; j++) {
                    const dx = pos[i*3]   - pos[j*3];
                    const dy = pos[i*3+1] - pos[j*3+1];
                    const dz = pos[i*3+2] - pos[j*3+2];
                    if (Math.sqrt(dx*dx + dy*dy + dz*dz) < CONNECT_DIST) {
                        const b = lc * 6;
                        lp[b]   = pos[i*3];   lp[b+1] = pos[i*3+1]; lp[b+2] = pos[i*3+2];
                        lp[b+3] = pos[j*3];   lp[b+4] = pos[j*3+1]; lp[b+5] = pos[j*3+2];
                        lc++;
                    }
                }
            }
            lineGeo.attributes.position.needsUpdate = true;
            lineGeo.setDrawRange(0, lc * 2);
        }

        // Smooth camera parallax
        camera.position.x += (targetX  - camera.position.x) * 0.04;
        camera.position.y += (-targetY - camera.position.y) * 0.04;
        camera.lookAt(scene.position);

        // Gentle z-rotation
        points.rotation.z = frame * 0.0001;

        renderer.render(scene, camera);
    }

    animate();
}
