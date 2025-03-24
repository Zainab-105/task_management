<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Http\ViewComposers\AdminComposer;
use App\Http\ViewComposers\LoginComposer;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(AdminComposer::class);
        $this->app->singleton(LoginComposer::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['admin.auth.*'], LoginComposer::class);
        view()->composer([
            'admin.pages.*', 'admin.layouts.*', 'components.*', 'admin.auth.verify'
        ], AdminComposer::class);
    }
}
