// import Alpine from 'alpinejs';

import intersect from '@alpinejs/intersect';

import { initWorkspaceHero } from './workspace-hero';

// import { initHeroThree } from './hero-three.js';

// ── Alpine ────────────────────────────────────────────────────────────────
// Alpine.plugin(intersect);
// window.Alpine = Alpine;
// Alpine.start();

// ── Three.js hero ─────────────────────────────────────────────────────────
// document.addEventListener('DOMContentLoaded', () => {
//     initHeroThree('hero-canvas');
// });

// import { initTerminal } from './terminal';

document.addEventListener(
    'DOMContentLoaded',
    () => {

        // initTerminal();
        initWorkspaceHero();

    }
);