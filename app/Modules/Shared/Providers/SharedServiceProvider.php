<?php

namespace App\Modules\Shared\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class SharedServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $webPath = __DIR__.'/../routes/web.php';

        if (file_exists($webPath)) {
            Route::middleware('web')
                ->group($webPath);
        }
    }

    public function register(): void
    {
        //
    }
}
