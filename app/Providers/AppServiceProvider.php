<?php

namespace App\Providers;

use App\Services\MailerLite\MailerLiteApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('haskey', function (MailerLiteApi $mailerLiteApi) {
            return $mailerLiteApi->hasKey();
        });
    }
}