<?php

namespace App\Providers;

use App\Interfaces\Thesaurus;
use App\Services\Thesaurus\ThesaurusService;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Thesaurus::class, fn() => new ThesaurusService);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::excludeUnvalidatedArrayKeys();
    }
}
