<?php

return [

    'categories' => [
        'All' => [
            'light' => 'bg-stone-50 text-stone-700 border-stone-200 hover:border-stone-300',
            'dot'   => 'bg-stone-500',
            'badge' => 'bg-stone-100 text-stone-700',
        ],

        'Backend' => [
            'light' => 'bg-violet-50 text-violet-700 border-violet-200 hover:border-violet-300',
            'dot'   => 'bg-violet-500',
            'badge' => 'bg-violet-100 text-violet-700',
        ],

        'Frontend' => [
            'light' => 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:border-emerald-300',
            'dot'   => 'bg-emerald-500',
            'badge' => 'bg-emerald-100 text-emerald-700',
        ],

        'Database' => [
            'light' => 'bg-amber-50 text-amber-700 border-amber-200 hover:border-amber-300',
            'dot'   => 'bg-amber-500',
            'badge' => 'bg-amber-100 text-amber-700',
        ],

        'Tools & AI' => [
            'light' => 'bg-slate-50 text-slate-700 border-slate-200 hover:border-slate-300',
            'dot'   => 'bg-slate-500',
            'badge' => 'bg-slate-100 text-slate-700',
        ]
    ],

    'technologies' => [
        // Backend
        'Laravel'       => 'Backend',
        'PHP'           => 'Backend',
        'REST APIs'     => 'Backend',
        'Eloquent ORM'  => 'Backend',
        'Socket.io'     => 'Backend',
        'Nginx'         => 'Backend',

        // Frontend
        'Livewire'      => 'Frontend',
        'Vue.js'        => 'Frontend',
        'Tailwind CSS'  => 'Frontend',
        'Alpine.js'     => 'Frontend',
        'Three.js'      => 'Frontend',

        // Database
        'MySQL'         => 'Database',

        // Tools & AI
        'Git / GitHub'  => 'Tools & AI',
        'Filament'      => 'Tools & AI',
        'FCM / Push'    => 'Tools & AI',
        'Claude Code'   => 'Tools & AI',
    ],

];
