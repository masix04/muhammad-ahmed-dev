<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Project;
use App\Models\SiteSetting;
use App\Models\Skill;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // All site settings, read from the database once per request.
        $this->app->scoped('site.settings', fn () => SiteSetting::loadAll());
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(['home'], function ($view) {

            // The hero slider: featured AND published projects, in the order set in the admin.
            $featuredProjects = Project::query()
                ->published()
                ->featured()
                ->ordered()
                ->take(7)->get();

            $view->with('featuredProjects', $featuredProjects);

            // Names for the scrolling strip at the bottom of the hero.
            $view->with('marqueeSkills', Skill::visible()->ordered()->pluck('name')->unique()->take(18)->values()->all());
        });

        // Force HTTPS in production (like on Render), and when a local tunnel
        // (e.g. ngrok) forwards the request over HTTPS.
        if (
            app()->environment('production')
            || (app()->environment('local') && request()->server('HTTP_X_FORWARDED_PROTO') === 'https')
        ) {
            URL::forceScheme('https');
        }
    }
}
