<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ModuleLoaderServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Registra os Service Providers dos módulos
        $modulesPath = app_path('Modules');
        $modules = array_filter(glob("$modulesPath/*"), 'is_dir');

        foreach ($modules as $module) {
            $provider = $module . '/Providers/' . basename($module) . 'ServiceProvider.php';
            if (file_exists($provider)) {
                $this->app->register('App\\Modules\\' . basename($module) . '\\Providers\\' . basename($module) . 'ServiceProvider');
            }
        }
    }

    public function boot()
    {
        // Caminho base para os módulos
        $modulesPath = app_path('Modules');
        $modules = array_filter(glob("$modulesPath/*"), 'is_dir');

        foreach ($modules as $module) {
            // Carrega rotas API
            $apiRoutesPath = $module . '/routes/api.php';
            if (file_exists($apiRoutesPath)) {
                require $apiRoutesPath; // Apenas carrega o arquivo de rotas
            }

            // Carrega rotas Web
            $webRoutesPath = $module . '/routes/web.php';
            if (file_exists($webRoutesPath)) {
                require $webRoutesPath; // Apenas carrega o arquivo de rotas
            }
        }
    }
}