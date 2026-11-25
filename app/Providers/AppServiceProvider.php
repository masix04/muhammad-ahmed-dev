<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use App\Models\Project;
use App\Models\SiteSetting;

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

            $featuredProjects = Project::query()
                ->where('is_featured', true)
                ->latest()->take(7)->get();

            $view->with('featuredProjects', $featuredProjects);
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
