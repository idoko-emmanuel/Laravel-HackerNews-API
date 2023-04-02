<?php

namespace App\Providers;

use App\Services\HackernewsDataService;
use Illuminate\Support\ServiceProvider;

class HackernewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('hackernews', function(){
            return new HackernewsDataService;
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
