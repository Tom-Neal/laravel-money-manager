<?php

namespace App\Providers;

use App\Models\ClientType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
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
            if(config('app.env') === 'testing') {
                View::composer('*', function ($view) {
                    $view->with('clientTypes', ClientType::all());
                });
            } else {
                view()->share('clientTypes', ClientType::all());
            }
        } catch (\Exception $ex) {
            report($ex);
        }

    }
}
