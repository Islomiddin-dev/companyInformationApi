<?php

namespace App\Providers;

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
        $this->app->bind(
            \App\Interfaces\Services\RegisterServiceInterface::class,
            \App\Services\RegisterService::class
        );

        $this->app->bind(
            \App\Interfaces\Services\LoginServiceInterface::class,
            \App\Services\LoginService::class
        );

        $this->app->bind(
            \App\Interfaces\Services\CompanyServiceInterface::class,
            \App\Services\CompanyService::class
        );

        $this->app->bind(
            \App\Interfaces\Repositories\CompanyRepositoryInterface::class,
            \App\Repositories\CompanyRepository::class
        );

        $this->app->bind(
            \App\Interfaces\Repositories\CompanyEmployeeRepositoryInterface::class,
            \App\Repositories\CompanyEmployeeRepository::class
        );

        $this->app->bind(
            \App\Interfaces\Services\CompanyEmployeeServiceInterface::class,
            \App\Services\CompanyEmployeeService::class
        );

        $this->app->bind(
            \App\Interfaces\Repositories\ProfileRepositoryInterface::class,
            \App\Repositories\ProfileRepository::class
        );

        $this->app->bind(
            \App\Interfaces\Services\ProfileServiceInterface::class,
            \App\Services\ProfileService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
