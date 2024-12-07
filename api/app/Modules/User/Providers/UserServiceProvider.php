<?php

namespace App\Modules\User\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Log::info('UserServiceProvider booted');
        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../views', 'user');
    }
}