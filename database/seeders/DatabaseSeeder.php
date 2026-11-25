<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // This runs on every container start, so it must never wipe content that
        // was edited in the admin panel. PortfolioSeeder empties the projects,
        // experience, skills and certifications tables before refilling them, so
        // it only runs on a brand-new database. Settings can't be deleted in the admin
        // panel, so having any means the site was already set up. Missing settings
        // are always added.
        if (SiteSetting::query()->exists()) {
            $this->call(SiteSettingsSeeder::class);

            return;
        }

        $this->call(PortfolioSeeder::class);
    }
}
