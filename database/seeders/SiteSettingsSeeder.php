<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

/**
 * Default site settings. Only adds keys that are missing, so anything edited in
 * the admin panel is kept. Run on its own with:
 *   php artisan db:seed --class=SiteSettingsSeeder
 */
class SiteSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'hero_name',      'value' => 'Muhammad Ahmed'],
            ['key' => 'hero_title',     'value' => 'Software Engineer · Laravel & AWS'],
            ['key' => 'hero_tagline',   'value' => '5+ years building full-stack web applications — trading LMS platforms, multi-vendor e-commerce, live sports feeds, and AI-powered tools. Focused on Laravel, Livewire & AWS cloud infrastructure.'],
            // One "number | label" per line. Empty hides the stats row.
            ['key' => 'hero_stats',     'value' => "5+ | Years\n10+ | Projects\n25k+ | Notifications\n1+ | Production Apps"],
            // Hero badges: set to '0' / '' to hide, non-empty to show.
            ['key' => 'open_to_work',   'value' => '0',    'type' => 'boolean'],
            ['key' => 'currently_building', 'value' => ''],
            ['key' => 'github_url',     'value' => 'https://github.com/masix04'],
            ['key' => 'linkedin_url',   'value' => 'https://www.linkedin.com/in/muhammad-ahmed-61b21b163/'],
            ['key' => 'email',          'value' => 'muhammadahmed5867@gmail.com'],
            ['key' => 'phone',          'value' => '+92 332 8426292'],
            ['key' => 'location',       'value' => 'Lahore, Pakistan'],

            // About section. Separate paragraphs with a blank line. Empty hides the section.
            ['key' => 'about_text',     'value' => "I'm a software engineer based in Lahore with 5+ years of experience building full-stack web applications with Laravel and Livewire. I've worked on trading-education LMS platforms, school management systems, live sports scoring and multi-vendor e-commerce.\n\nToday I work at Finz Games, where I write Laravel code and own the cloud side too: AWS Lightsail hosting, S3 media storage, CloudFront delivery and a site-to-site VPN to a partner's APIs. Earlier, I led a team of 3 developers on SportScore, a live multi-sport scoring platform.\n\nI also use AI-assisted workflows, such as Claude Code, to prototype faster and debug more quickly."],
            // A photo shown next to the About text. A full URL, or a path on this site
            // (e.g. images/me.jpg inside public/). Empty hides it.
            ['key' => 'profile_photo',  'value' => ''],

            // CV download button. A full URL, or a path on this site (e.g. cv/muhammad-ahmed.pdf
            // inside public/). Empty hides every Download CV button.
            ['key' => 'cv_url',         'value' => ''],

            // Image shown when a link to the site is shared (LinkedIn, Slack, X…).
            // Use a PNG or JPG, ideally 1200×630. Empty means no image.
            ['key' => 'og_image',       'value' => ''],
        ];

        foreach ($settings as $setting) {
            SiteSetting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
