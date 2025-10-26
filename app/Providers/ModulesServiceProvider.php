<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ModulesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Scan every module for its service provider
        foreach (glob(app_path('Modules/*/Providers/*ServiceProvider.php')) as $providerPath) {
            $moduleName = basename(dirname(dirname($providerPath)));
            $providerClass = "App\\Modules\\{$moduleName}\\Providers\\".basename($providerPath, '.php');

            // Make sure class exists and is autoloadable
            if (class_exists($providerClass)) {
                $this->app->register($providerClass);
            }
        }
    }

    public function boot(): void
    {
        //
    }
}
