<?php

namespace App\Providers;

use App\Models\MainModel;
use Illuminate\Support\ServiceProvider;

class MainServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Mengikat model ke container
        $this->app->singleton(MainModel::class, function ($app) {
            return new MainModel();
        });
    }

    public function boot()
    {
        //
    }
}
