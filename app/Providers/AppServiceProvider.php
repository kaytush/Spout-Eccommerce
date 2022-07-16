<?php

namespace App\Providers;

use App\Models\GeneralSettings;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

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
        Paginator::useBootstrapFive();
        //
        Schema::defaultStringLength(191);

        $data['basic'] =  GeneralSettings::first();
        $data['gnl'] =  GeneralSettings::first();
        $data['time'] = Carbon::now();
        View::share($data);
    }
}
