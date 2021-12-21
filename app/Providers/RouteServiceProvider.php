<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->bootApiRoutes();
            $this->bootWebRoutes();
        });
    }

    protected function bootApiRoutes(): void
    {
        $this->bootRoutes('routes/api.php',
            static fn () => Route::prefix('api')->middleware('api')
        );
    }

    protected function bootWebRoutes(): void
    {
        $this->bootRoutes('routes/web.php',
            static fn () => Route::middleware('web')
        );
    }

    protected function bootRoutes(string $filename, callable $registrar): void
    {
        if (file_exists(base_path($filename))) {
            $registrar()->group(base_path($filename));
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
