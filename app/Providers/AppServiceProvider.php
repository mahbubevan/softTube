<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

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
        Cashier::calculateTaxes();
        $setting = GeneralSetting::first();

        view()->share("appName",$setting->appname);
        view()->share("logo",$setting->logo);
        view()->share("favicon",$setting->favicon);
        view()->share("setting",$setting);
        
    }
}
