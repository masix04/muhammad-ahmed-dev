<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\{Project, WorkExperience, Skill, Certification, SiteSetting};

class PortfolioSeeder extends Seeder
{
    public function run(): void
    {
        // ── Site settings ─────────────────────────────────────────────────────
        $settings = [
            ['key' => 'hero_name',      'value' => 'Muhammad Ahmed'],
            ['key' => 'hero_title',     'value' => 'PHP / Laravel Developer'],
            ['key' => 'hero_tagline',   'value' => '3+ years building full-stack web applications — trading LMS platforms, multi-vendor e-commerce, live sports feeds, and AI-powered tools.'],
            ['key' => 'open_to_work',   'value' => '1',    'type' => 'boolean'],
            ['key' => 'github_url',     'value' => 'https://github.com/masix04'],
            ['key' => 'linkedin_url',   'value' => 'https://www.linkedin.com/in/muhammad-ahmed-61b21b163/'],
            ['key' => 'email',          'value' => 'muhammadahmed5867@gmail.com'],
            ['key' => 'phone',          'value' => '+92 332 8426292'],
            ['key' => 'location',       'value' => 'Lahore, Pakistan'],
        ];
        foreach ($settings as $s) {
            SiteSetting::updateOrCreate(['key' => $s['key']], $s);
        }

        // ── Work experience ───────────────────────────────────────────────────
        WorkExperience::truncate();

        WorkExperience::create([
            'role'         => 'Freelance Product Developer',
            'company'      => 'Independent',
            'location'     => 'Lahore',
            'period'       => 'Feb 2026 – Present',
            'start_date'   => '2026-02-01',
            'end_date'     => null,
            'is_current'   => true,
            'sort_order'   => 1,
            'bullets'      => [
                ['bullet' => 'Multi-tenant e-commerce platform with per-seller storefronts, Stripe & Cashmaal payment integrations'],
                ['bullet' => 'AI-powered workout tracker with daily/weekly performance reports and personalized routine suggestions'],
                ['bullet' => 'Used Claude Code for debugging, rapid prototyping, and workflow automation'],
            ],
            'sub_projects' => [
                ['name' => 'Multi-Tenant E-commerce', 'desc' => 'Multi-vendor platform with seller management, product variants, media galleries, and payment gateways.', 'tags' => ['Laravel','Livewire','Alpine.js','Tailwind','Stripe','MySQL']],
                ['name' => 'Track Routine Workout',    'desc' => 'AI-powered fitness app with routine management, task tracking, and automated performance reports.',    'tags' => ['Laravel','AI','MySQL']],
            ],
        ]);

        WorkExperience::create([
            'role'         => 'Backend Developer (Laravel | Livewire)',
            'company'      => 'RoboEyeTech',
            'location'     => 'Lahore',
            'period'       => 'Jun 2024 – Dec 2025',
            'start_date'   => '2024-06-01',
            'end_date'     => '2025-12-31',
            'is_current'   => false,
            'sort_order'   => 2,
            'bullets'      => [
                ['bullet' => 'Built role-based dashboards, structured learning modules, and live webinar streaming via OBS + MUX'],
                ['bullet' => 'Developed School LMS with timetable scheduling, FCM notifications, and RESTful APIs for mobile apps'],
                ['bullet' => 'Built property listing platform with dynamic filtering and optimised data handling'],
                ['bullet' => 'Leveraged AI-assisted development workflows to accelerate feature implementation'],
            ],
            'sub_projects' => [
                ['name' => 'Forex/Kleos/ILMU', 'desc' => 'Trading education LMS for traders, educators and students with webinar streaming and live market data.', 'tags' => ['Laravel','Livewire','MUX','FCM','FMP','Nginx']],
                ['name' => 'TeachersLink',     'desc' => 'School management and LMS with timetable scheduling, progress tracking, and parent-facing features.',     'tags' => ['Laravel','Livewire','MySQL','FCM']],
                ['name' => 'SchoolApp',        'desc' => 'School management platform for parents, teachers and students with mobile integration.',                   'tags' => ['Laravel','Livewire','MySQL','FCM']],
            ],
        ]);

        WorkExperience::create([
            'role'         => 'PHP Laravel Developer',
            'company'      => 'Sixlogics / VentureDK',
            'location'     => 'Lahore',
            'period'       => 'May 2021 – Jun 2024',
            'start_date'   => '2021-05-01',
            'end_date'     => '2024-06-30',
            'is_current'   => false,
            'sort_order'   => 3,
            'bullets'      => [
                ['bullet' => 'Built RESTful APIs and CMS functionalities for multiple mobile and web applications'],
                ['bullet' => 'Led a team of 3 developers on SportScore — live multi-sport scoring platform'],
                ['bullet' => 'Coordinated with international project managers on API delivery and development workflows'],
                ['bullet' => 'Developed a Laravel boilerplate to automate MVC structure generation with custom stubs'],
            ],
            'sub_projects' => [
                ['name' => 'TeamTalk',      'desc' => 'Sports platform with live scores, transfer updates, and match notifications.', 'tags' => ['Laravel','Socket.io','Echo','FCM','Nginx']],
                ['name' => 'SportScore',    'desc' => 'Multi-sport live scoring platform. Led team of 3.',                            'tags' => ['Laravel','MySQL','FCM','Socket.io','SonarQube']],
                ['name' => 'KismaSports',   'desc' => 'SEO and multilingual sports platform built with Vue.js.',                       'tags' => ['Vue.js','Laravel','REST APIs']],
                ['name' => 'GreyHound Racing', 'desc' => 'Live greyhound racing platform with real-time event tracking.',            'tags' => ['CodeIgniter','AngularJS','MySQL']],
                ['name' => 'Laravel Boilerplate', 'desc' => 'Automated MVC generation with custom stubs and File Facade.',           'tags' => ['Laravel','PHP']],
            ],
        ]);

        // ── Projects ──────────────────────────────────────────────────────────
        Project::truncate();

        $projects = [
            [
                'title' => 'Forex/Kleos/ILMU', 'slug' => 'forex-kleos-ilmu', 'category' => 'LMS',
                'short_description' => 'Educational trading and LMS platform for traders, educators, and students with live webinar streaming via OBS/MUX and real-time market data.',
                'full_description'  => '<p>A comprehensive learning management system built for the trading education space. Features include role-based dashboards for educators and students, structured learning modules, live webinar streaming integration using OBS and MUX, and real-time Forex market data from FMP.</p><h3>Key features</h3><ul><li>Role-based access control (admin, educator, student)</li><li>Live webinar streaming with OBS/MUX integration</li><li>Real-time Forex market data display</li><li>Firebase Cloud Messaging for push notifications</li><li>Responsive dashboards with Livewire reactivity</li></ul>',
                'tech_tags' => ['Laravel','Livewire','MySQL','FCM','MUX','Nginx','PHP'],
                'is_featured' => true, 'sort_order' => 1, 'top_class' => 'top-[10%]', 'left_class' => 'left-[55%]',
            ],

            [
                'title' => 'Multi-Tenant E-commerce', 'slug' => 'multi-tenant-ecommerce', 'category' => 'E-commerce',
                'short_description' => 'Multi-vendor platform with per-seller storefronts, product variant systems, media galleries, and Stripe/COD/Cashmaal payment gateways.',
                'full_description'  => '<p>A fully featured multi-tenant e-commerce solution where each seller gets their own customisable storefront within a shared Laravel infrastructure.</p><h3>Key features</h3><ul><li>Multi-tenant architecture with per-seller theming</li><li>Product variants (size, colour, etc.) with real-time pricing via Livewire</li><li>Payment gateway integrations: Stripe, COD, Cashmaal</li><li>Seller management dashboard in Filament</li><li>Media galleries with drag-and-drop uploads</li><li>AI-assisted development with Claude Code</li></ul>',
                'tech_tags' => ['Laravel','Livewire','Alpine.js','Tailwind CSS','Stripe','MySQL','Filament'],
                'is_featured' => true, 'sort_order' => 2, 'top_class' => 'top-[38%]', 'left_class' => 'left-[8%]'
            ],

            [
                'title' => 'TeachersLink School LMS', 'slug' => 'teacherslink', 'category' => 'LMS',
                'short_description' => 'School management and LMS for students, teachers and parents with timetable scheduling, RESTful APIs for mobile, and FCM notifications.',
                'full_description'  => '<p>Built as part of a 4-member team at RoboEyeTech, TeachersLink serves schools across web and mobile platforms.</p><h3>Key features</h3><ul><li>Timetable and calendar scheduling system</li><li>Student progress and attendance tracking for parents</li><li>RESTful APIs consumed by iOS and Android apps</li><li>Push notifications via Firebase Cloud Messaging</li><li>Academic activity management for teachers</li></ul>',
                'tech_tags' => ['Laravel','Livewire','MySQL','FCM','REST APIs'],
                'is_featured' => true, 'sort_order' => 3, 'top_class' => 'top-[25%]', 'left_class' => 'left-[65%]'
            ],

            [
                'title' => 'Track Routine Workout', 'slug' => 'track-routine-workout', 'category' => 'Fitness',
                'short_description' => 'AI-powered fitness tracking app with custom routine creation, task completion tracking, automated weekly performance reports, and personalised suggestions.',
                'tech_tags' => ['Laravel','MySQL','AI','PHP'],
                'is_featured' => false, 'sort_order' => 4, 'top_class' => 'top-[62%]', 'left_class' => 'left-[40%]'
            ],

            [
                'title' => 'TeamTalk / SportScore', 'slug' => 'teamtalk-sportscore', 'category' => 'Sports',
                'short_description' => 'Live sports scoring platform with Socket.io real-time updates, transfer news, match notifications, and CMS for mobile app management.',
                'tech_tags' => ['Laravel','MySQL','Socket.io','Echo','FCM','SonarQube','Nginx'],
                'is_featured' => false, 'sort_order' => 5, 'top_class' => 'top-[72%]', 'left_class' => 'left-[70%]'
            ],

            [
                'title' => 'GreyHound Racing', 'slug' => 'greyhound-racing', 'category' => 'Sports',
                'short_description' => 'Live greyhound racing platform with race tracking, player profiles, and real-time event updates. Frontend in AngularJS, backend in CodeIgniter.',
                'tech_tags' => ['PHP','CodeIgniter','AngularJS','MySQL','JavaScript'],
                'is_featured' => false, 'sort_order' => 6, 'top_class' => 'top-[80%]', 'left_class' => 'left-[15%]'
            ],
        ];

        foreach ($projects as $p) {
            Project::create(array_merge($p, ['is_published' => true]));
        }

        // ── Skills ────────────────────────────────────────────────────────────
        Skill::truncate();

        $skills = [
            // Backend
            ['name' => 'Laravel',      'category' => 'Backend',  'proficiency' => 92, 'icon' => 'brand-laravel',   'sort_order' => 1],
            ['name' => 'PHP',          'category' => 'Backend',  'proficiency' => 90, 'icon' => 'brand-php',       'sort_order' => 2],
            ['name' => 'Livewire',     'category' => 'Backend',  'proficiency' => 88, 'icon' => 'bolt',            'sort_order' => 3],
            ['name' => 'REST APIs',    'category' => 'Backend',  'proficiency' => 90, 'icon' => 'api',             'sort_order' => 4],
            ['name' => 'Filament',     'category' => 'Backend',  'proficiency' => 82, 'icon' => 'layout-dashboard','sort_order' => 5],
            // Frontend
            ['name' => 'Tailwind CSS', 'category' => 'Frontend', 'proficiency' => 85, 'icon' => 'brand-tailwind',  'sort_order' => 1],
            ['name' => 'Alpine.js',    'category' => 'Frontend', 'proficiency' => 78, 'icon' => 'brand-javascript','sort_order' => 2],
            ['name' => 'Three.js',     'category' => 'Frontend', 'proficiency' => 65, 'icon' => 'brand-threejs',   'sort_order' => 3],
            ['name' => 'Vue.js',       'category' => 'Frontend', 'proficiency' => 65, 'icon' => 'brand-vue',       'sort_order' => 4],
            // Database
            ['name' => 'MySQL',        'category' => 'Database', 'proficiency' => 86, 'icon' => 'database',        'sort_order' => 1],
            ['name' => 'Eloquent ORM', 'category' => 'Database', 'proficiency' => 88, 'icon' => 'table',           'sort_order' => 2],
            // Tools & AI
            ['name' => 'FCM / Push',   'category' => 'Tools & AI','proficiency' => 80, 'icon' => 'bell',           'sort_order' => 1],
            ['name' => 'Socket.io',    'category' => 'Tools & AI','proficiency' => 72, 'icon' => 'arrows-exchange','sort_order' => 2],
            ['name' => 'Claude Code',  'category' => 'Tools & AI','proficiency' => 78, 'icon' => 'robot',          'sort_order' => 3],
            ['name' => 'Git / GitHub', 'category' => 'Tools & AI','proficiency' => 85, 'icon' => 'brand-github',   'sort_order' => 4],
            ['name' => 'Nginx',        'category' => 'Tools & AI','proficiency' => 70, 'icon' => 'server',         'sort_order' => 5],
        ];

        foreach ($skills as $s) {
            Skill::create(array_merge($s, ['is_visible' => true]));
        }

        // ── Certifications ────────────────────────────────────────────────────
        Certification::truncate();

        $certs = [
            ['title' => 'Python for Everybody',           'issuer' => 'Coursera',              'issued_date' => '2023',      'sort_order' => 1],
            ['title' => 'Generative AI Workshop',         'issuer' => 'AI Workshop / VibeCoding','issued_date' => '2024',     'sort_order' => 2],
            ['title' => 'AI Project Dev Tools Practice',  'issuer' => 'Self-directed',          'issued_date' => '2024–2025', 'sort_order' => 3,
            'description' => 'Hands-on practice with Replit, Atom, Claude Code, and Figma Make for AI-assisted development workflows.'],
            ['title' => 'Communication & Personal Dev',   'issuer' => 'Sixlogics',              'issued_date' => '2022',      'sort_order' => 4],
            ['title' => 'Speed Programming Competition',  'issuer' => 'University of Lahore',   'issued_date' => '2018–2020', 'sort_order' => 5],
        ];

        foreach ($certs as $c) {
            Certification::create(array_merge($c, ['is_visible' => true]));
        }

        $this->command->info('Portfolio seeded with real CV data!');
    }
}