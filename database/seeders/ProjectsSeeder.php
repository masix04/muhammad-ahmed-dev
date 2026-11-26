<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

/**
 * The portfolio projects. Only adds projects that are missing (matched by slug), so
 * anything edited in the admin panel is kept. Run on its own with:
 *   php artisan db:seed --class=ProjectsSeeder
 *
 * Featured projects (is_featured) become the cards in the hero slider; top_class and
 * left_class are where their card sits.
 */
class ProjectsSeeder extends Seeder
{
    public function run(): void
    {
        $projects = [
            [
                'title' => 'Forex/Kleos/ILMU', 'slug' => 'forex-kleos-ilmu', 'category' => 'LMS',
                'my_role' => 'Backend Developer at RoboEyeTech',
                'short_description' => 'Educational trading and LMS platform for traders, educators, and students with live webinar streaming via OBS/MUX and real-time market data.',
                'full_description'  => '<p>A comprehensive learning management system built for the trading education space. Features include role-based dashboards for educators and students, structured learning modules, live webinar streaming integration using OBS and MUX, and real-time Forex market data from FMP.</p><h3>Key features</h3><ul><li>Role-based access control (admin, educator, student)</li><li>Live webinar streaming with OBS/MUX integration</li><li>Real-time Forex market data display</li><li>Firebase Cloud Messaging for push notifications</li><li>Responsive dashboards with Livewire reactivity</li></ul>',
                'tech_tags' => ['Laravel','Livewire','MySQL','FCM','MUX','Nginx','PHP'],
                'is_featured' => true, 'sort_order' => 1, 'top_class' => 'top-[10%]', 'left_class' => 'left-[55%]',
            ],

            [
                'title' => 'Multi-Tenant E-commerce', 'slug' => 'multi-tenant-ecommerce', 'category' => 'E-commerce',
                'my_role' => 'Freelance product developer',
                'short_description' => 'Multi-vendor platform with per-seller storefronts, product variant systems, media galleries, and Stripe/COD/Cashmaal payment gateways.',
                'full_description'  => '<p>A fully featured multi-tenant e-commerce solution where each seller gets their own customisable storefront within a shared Laravel infrastructure.</p><h3>Key features</h3><ul><li>Multi-tenant architecture with per-seller theming</li><li>Product variants (size, colour, etc.) with real-time pricing via Livewire</li><li>Payment gateway integrations: Stripe, COD, Cashmaal</li><li>Seller management dashboard in Filament</li><li>Media galleries with drag-and-drop uploads</li><li>AI-assisted development with Claude Code</li></ul>',
                'tech_tags' => ['Laravel','Livewire','Alpine.js','Tailwind CSS','Stripe','MySQL','Filament'],
                'is_featured' => true, 'sort_order' => 2, 'top_class' => 'top-[38%]', 'left_class' => 'left-[8%]'
            ],

            [
                'title' => 'TeachersLink School LMS', 'slug' => 'teacherslink', 'category' => 'LMS',
                'my_role' => 'Backend Developer in a 4-member team at RoboEyeTech',
                'short_description' => 'School management and LMS for students, teachers and parents with timetable scheduling, RESTful APIs for mobile, and FCM notifications.',
                'full_description'  => '<p>Built as part of a 4-member team at RoboEyeTech, TeachersLink serves schools across web and mobile platforms.</p><h3>Key features</h3><ul><li>Timetable and calendar scheduling system</li><li>Student progress and attendance tracking for parents</li><li>RESTful APIs consumed by iOS and Android apps</li><li>Push notifications via Firebase Cloud Messaging</li><li>Academic activity management for teachers</li></ul>',
                'tech_tags' => ['Laravel','Livewire','MySQL','FCM','REST APIs'],
                'is_featured' => true, 'sort_order' => 3, 'top_class' => 'top-[25%]', 'left_class' => 'left-[65%]'
            ],

            [
                'title' => 'Track Routine Workout', 'slug' => 'track-routine-workout', 'category' => 'Fitness',
                'short_description' => 'AI-powered fitness tracking app with custom routine creation, task completion tracking, automated weekly performance reports, and personalised suggestions.',
                'tech_tags' => ['Laravel','MySQL','AI','PHP'],
                'is_featured' => false, 'sort_order' => 7, 'top_class' => 'top-[62%]', 'left_class' => 'left-[40%]'
            ],

            [
                'title' => 'TeamTalk / SportScore', 'slug' => 'teamtalk-sportscore', 'category' => 'Sports',
                'my_role' => 'Led a team of 3 developers at Sixlogics',
                'short_description' => 'Live sports scoring platform with Socket.io real-time updates, transfer news, match notifications, and CMS for mobile app management.',
                'tech_tags' => ['Laravel','MySQL','Socket.io','Echo','FCM','SonarQube','Nginx'],
                'is_featured' => false, 'sort_order' => 8, 'top_class' => 'top-[72%]', 'left_class' => 'left-[70%]'
            ],

            [
                'title' => 'GreyHound Racing', 'slug' => 'greyhound-racing', 'category' => 'Sports',
                'short_description' => 'Live greyhound racing platform with race tracking, player profiles, and real-time event updates. Frontend in AngularJS, backend in CodeIgniter.',
                'tech_tags' => ['PHP','CodeIgniter','AngularJS','MySQL','JavaScript'],
                'is_featured' => false, 'sort_order' => 9, 'top_class' => 'top-[80%]', 'left_class' => 'left-[15%]'
            ],

            // ── Added later ───────────────────────────────────────────────────
            // Worded generically on purpose: no client, partner or product names.
            [
                'title' => 'Web Portal Platform', 'slug' => 'web-portal-platform', 'category' => 'Other',
                'my_role' => 'Software Engineer: Laravel development and cloud infrastructure',
                'short_description' => 'Laravel-based web portal platform that I develop and host end to end, with the cloud infrastructure on AWS: Lightsail hosting, S3 media storage and a CloudFront CDN.',
                'full_description'  => '<p>A production web portal platform. I work on the Laravel application and also own the cloud infrastructure it runs on, from hosting to media delivery.</p><h3>Key responsibilities</h3><ul><li>Laravel application development</li><li>Hosting on an AWS Lightsail instance</li><li>S3 buckets for media storage</li><li>CloudFront CDN distribution for media</li></ul>',
                'tech_tags' => ['Laravel','AWS','AWS Lightsail','Amazon S3','CloudFront'],
                'is_featured' => true, 'sort_order' => 4, 'top_class' => 'top-[62%]', 'left_class' => 'left-[40%]',
            ],

            [
                'title' => 'Stock Assistant', 'slug' => 'stock-assistant', 'category' => 'Fintech',
                'my_role' => 'Personal project, designed and built by me',
                'short_description' => 'Personal portfolio tracker for the Pakistan Stock Exchange: live quotes with automatic fallback sources, price alerts with push notifications, dividends, weekly summaries and broker PDF statement import.',
                'full_description'  => '<p>A portfolio tracker I built for my own investing on the Pakistan Stock Exchange (PSX). It keeps my holdings, trades and dividends in one place, watches the market for me, and tells me when something moves.</p><h3>Key features</h3><ul><li>Live quotes from several PSX data sources, with automatic fallback and a circuit breaker when a source fails</li><li>Holdings with buy and sell lots, cost basis, and the broker average compared with my own trades</li><li>Alerts for daily moves, moves since purchase and index moves, delivered as push notifications</li><li>Dividends, monthly contributions and a weekly summary</li><li>Import from CSV files and broker PDF statements (pure-PHP PDF parsing)</li><li>Multiple broker profiles, plus backup and restore</li><li>AI-written news summaries using the Claude API</li><li>Mobile app built with NativePHP; web version deployed with Docker on Render</li></ul>',
                'challenge' => 'Following my PSX holdings, trade history and daily moves meant working from broker statements and separate websites.',
                'solution'  => 'A Laravel and Livewire app that imports my broker statements, reconciles the trade ledger, fetches quotes from several sources with fallbacks, and alerts me by push notification.',
                'outcome'   => 'In regular personal use: it solves my own portfolio-tracking problem.',
                'tech_tags' => ['Laravel','Livewire','SQLite','NativePHP','FCM','Claude API','Docker'],
                'is_featured' => true, 'sort_order' => 5, 'top_class' => 'top-[72%]', 'left_class' => 'left-[70%]',
            ],

            [
                'title' => 'Daily Routine Log', 'slug' => 'daily-routine-log', 'category' => 'Other',
                'my_role' => 'Personal project, designed and built by me',
                'short_description' => 'Private, single-user life log: a searchable timeline of daily routines, exercise, expenses, petrol, vehicle maintenance and notes, with image attachments and local-first sync.',
                'full_description'  => '<p>A private life log that answers one question: what happened on a particular date? It replaces scattered notes, screenshots and ad-hoc records with one structured, searchable personal history.</p><h3>Key features</h3><ul><li>Chronological timeline of routines, exercise, expenses, petrol, vehicle maintenance, life events and notes, with image attachments</li><li>Local-first: every device keeps its own SQLite database (in the browser on the web, native on Android)</li><li>Sync through Google Drive snapshots, merged record by record with hybrid logical clocks, so nothing is silently deleted or overwritten</li><li>Vue 3 web app wrapped for Android with Capacitor</li><li>Laravel back end for sign-in, the Google OAuth broker, AI-assisted PDF migration and snapshot relay</li><li>Tested with Vitest on the client and PHPUnit on the server</li></ul>',
                'challenge' => 'My routines, exercise, expenses, petrol and vehicle records were scattered across notes apps, screenshots and ad-hoc records.',
                'solution'  => 'A local-first app where each device owns a real SQLite database and Google Drive carries snapshots between devices, merged record by record so nothing is lost.',
                'outcome'   => 'Now my single place for personal records, and in regular use.',
                'tech_tags' => ['Vue.js','Laravel','SQLite','Capacitor','Tailwind CSS','Google Drive API'],
                'is_featured' => false, 'sort_order' => 6, 'top_class' => 'top-[80%]', 'left_class' => 'left-[15%]',
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(
                ['slug' => $project['slug']],
                array_merge($project, ['is_published' => true])
            );
        }
    }
}
