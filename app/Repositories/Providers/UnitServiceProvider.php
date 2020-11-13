<?php


namespace App\Repositories\Providers;
use Illuminate\Support\ServiceProvider;


class UnitServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('App\Repositories\IUnitRepository', 'App\Repositories\UnitRepository');
    }
}

