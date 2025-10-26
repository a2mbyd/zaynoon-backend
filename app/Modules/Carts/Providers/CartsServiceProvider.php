<?php

namespace App\Modules\Carts\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CartsServiceProvider extends ServiceProvider
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
