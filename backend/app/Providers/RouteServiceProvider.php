<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes(); 
    }

    protected function mapApiRoutes()
    {
        Route::prefix('api') 
            ->middleware('api') 
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php')); 
    }

    protected function mapWebRoutes()
    {
        Route::middleware('web') 
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php')); 
    }
}
