<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use App\DatabaseUserNotif;
use App\DatabaseAdminNotif;
use Illuminate\View\View as ViewView;
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
        view()->composer('layouts.admin-app', function (ViewView $view) {
            $notif = DatabaseAdminNotif::where('read_at', null)->orderBy('created_at', 'desc')->get();
            $view->with('notif', $notif);
        });
        
        view()->composer('layouts.app', function (ViewView $view) {
            if (!is_null(Auth::user())) {
                $notif = \App\DatabaseUserNotif::where('read_at', null)->where('notifiable_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
                $view->with('notif', $notif);
            }
        });
       Schema::defaultStringLength(191);
    }
}
