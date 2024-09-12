<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

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
        View::composer('*', function ($view) {
            $auth_group = null;
            if (Auth::guard('admin')->check()) {
                $auth_group = 'admin';
            } elseif (Auth::check()) {
                $auth_group = 'user';
            }
            $view->with('auth_group', $auth_group);
        });
    }
}
