import * as THREE from 'three';

export function initHeroThree(canvasId) {
    const canvas = document.getElementById(canvasId);

    if (!canvas) return;

    // ------------------------------------------------
    // Renderer
    // ------------------------------------------------

    const renderer = new THREE.WebGLRenderer({
        canvas,
        alpha: true,
        antialias: true,
    });

    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    renderer.setClearColor(0x000000, 0);

    // ------------------------------------------------
    // Scene
    // ------------------------------------------------

    const scene = new THREE.Scene();

    const camera = new THREE.PerspectiveCamera(
        50,
        1,
        0.1,
        100
    );

    camera.position.z = 8;

    // ------------------------------------------------
    // Colors
    // ------------------------------------------------

    const COLORS = {
        purple: 0x534AB7,
        purpleLight: 0xAFA9EC,
        green: 0x1D9E75,
        amber: 0xEF9F27,
        line: 0xD9D5FF,
        white: 0xffffff,
    };

    // ------------------------------------------------
    // Core
    // ------------------------------------------------

    const coreGroup = new THREE.Group();

    const coreGlow = new THREE.Mesh(
        new THREE.CircleGeometry(0.9, 64),
        new THREE.MeshBasicMaterial({
            color: COLORS.purple,
            transparent: true,
            opacity: 0.15,
        })
    );

    const core = new THREE.Mesh(
        new THREE.CircleGeometry(0.18, 64),
        new THREE.MeshBasicMaterial({
            color: COLORS.purple,
        })
    );

    coreGroup.add(coreGlow);
    coreGroup.add(core);

    scene.add(coreGroup);

    // ------------------------------------------------
    // Nodes
    // ------------------------------------------------

    const nodeGroup = new THREE.Group();
    scene.add(nodeGroup);

    const nodes = [];

    const nodeData = [
        { angle: 0, color: COLORS.green },
        { angle: 0.9, color: COLORS.purpleLight },
        { angle: 1.8, color: COLORS.amber },
        { angle: 2.7, color: COLORS.green },
        { angle: 3.6, color: COLORS.purpleLight },
        { angle: 4.5, color: COLORS.amber },
        { angle: 5.4, color: COLORS.green },
    ];

    nodeData.forEach((node) => {
        const mesh = new THREE.Mesh(
            new THREE.CircleGeometry(0.08, 32),
            new THREE.MeshBasicMaterial({
                color: node.color,
            })
        );

        nodeGroup.add(mesh);

        nodes.push({
            mesh,
            angle: node.angle,
            radius: 2.4 + Math.random() * 0.6,
            speed: 0.0007 + Math.random() * 0.0006,
            offset: Math.random() * Math.PI * 2,
        });
    });

    // ------------------------------------------------
    // Connection Lines
    // ------------------------------------------------

    const lineMaterial = new THREE.LineBasicMaterial({
        color: COLORS.line,
        transparent: true,
        opacity: 0.35,
    });

    const lines = [];

    nodes.forEach((node) => {
        const geometry = new THREE.BufferGeometry();

        geometry.setAttribute(
            'position',
            new THREE.Float32BufferAttribute(
                [0, 0, 0, 0, 0, 0],
                3
            )
        );

        const line = new THREE.Line(
            geometry,
            lineMaterial
        );

        scene.add(line);

        lines.push({
            line,
            node,
        });
    });

    // ------------------------------------------------
    // Data Packets
    // ------------------------------------------------

    const packets = [];

    for (let i = 0; i < nodes.length; i++) {
        const packet = new THREE.Mesh(
            new THREE.CircleGeometry(0.03, 16),
            new THREE.MeshBasicMaterial({
                color: COLORS.white,
            })
        );

        scene.add(packet);

        packets.push({
            mesh: packet,
            node: nodes[i],
            progress: Math.random(),
        });
    }

    // ------------------------------------------------
    // Stars
    // ------------------------------------------------

    const STAR_COUNT = 250;

    const starPositions = new Float32Array(
        STAR_COUNT * 3
    );

    for (let i = 0; i < STAR_COUNT; i++) {
        starPositions[i * 3] =
            (Math.random() - 0.5) * 18;

        starPositions[i * 3 + 1] =
            (Math.random() - 0.5) * 10;

        starPositions[i * 3 + 2] =
            (Math.random() - 0.5) * 5;
    }

    const starGeometry = new THREE.BufferGeometry();

    starGeometry.setAttribute(
        'position',
        new THREE.BufferAttribute(
            starPositions,
            3
        )
    );

    const stars = new THREE.Points(
        starGeometry,
        new THREE.PointsMaterial({
            color: 0xffffff,
            size: 0.02,
            transparent: true,
            opacity: 0.4,
        })
    );

    scene.add(stars);

    // ------------------------------------------------
    // Mouse Parallax
    // ------------------------------------------------

    let targetX = 0;
    let targetY = 0;

    window.addEventListener('mousemove', (e) => {
        targetX =
            (e.clientX / window.innerWidth - 0.5) *
            0.4;

        targetY =
            (e.clientY / window.innerHeight - 0.5) *
            0.25;
    });

    // ------------------------------------------------
    // Resize
    // ------------------------------------------------

    function resize() {
        const width = canvas.offsetWidth;
        const height = canvas.offsetHeight;

        renderer.setSize(width, height, false);

        camera.aspect = width / height;
        camera.updateProjectionMatrix();
    }

    resize();

    window.addEventListener('resize', resize);

    // ------------------------------------------------
    // Animation
    // ------------------------------------------------

    const clock = new THREE.Clock();

    function animate() {
        requestAnimationFrame(animate);

        const t = clock.getElapsedTime();

        // Core pulse

        const pulse =
            1 + Math.sin(t * 1.5) * 0.08;

        core.scale.setScalar(pulse);
        coreGlow.scale.setScalar(
            pulse * 1.15
        );

        // Nodes

        nodes.forEach((node) => {
            node.angle += node.speed * 10;

            const x =
                Math.cos(node.angle) *
                node.radius;

            const y =
                Math.sin(node.angle) *
                    node.radius +
                Math.sin(
                    t + node.offset
                ) *
                    0.15;

            node.mesh.position.set(
                x,
                y,
                0
            );
        });

        // Lines

        lines.forEach(({ line, node }) => {
            const pos =
                line.geometry.attributes
                    .position.array;

            pos[0] = 0;
            pos[1] = 0;
            pos[2] = 0;

            pos[3] =
                node.mesh.position.x;
            pos[4] =
                node.mesh.position.y;
            pos[5] = 0;

            line.geometry.attributes.position.needsUpdate =
                true;
        });

        // Packets

        packets.forEach((packet) => {
            packet.progress += 0.004;

            if (packet.progress > 1) {
                packet.progress = 0;
            }

            packet.mesh.position.lerpVectors(
                new THREE.Vector3(
                    0,
                    0,
                    0
                ),
                packet.node.mesh.position,
                packet.progress
            );
        });

        // Stars

        stars.rotation.z =
            t * 0.01;

        // Camera

        camera.position.x +=
            (targetX -
                camera.position.x) *
            0.03;

        camera.position.y +=
            (-targetY -
                camera.position.y) *
            0.03;

        camera.lookAt(0, 0, 0);

        renderer.render(
            scene,
            camera
        );
    }

    animate();
}