<?php

namespace App\Providers;

use App\Models\ClientType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
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

        Model::preventLazyLoading(!$this->app->isProduction());
        Model::unguard();
        Paginator::useBootstrap();

        try {
            view()->share('clientTypes', ClientType::all());
        } catch (\Exception $ex) {
            report($ex);
        }

    }
}
