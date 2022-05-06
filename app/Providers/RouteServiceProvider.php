<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('signin', function (Request $request) {
            return Limit::perMinute(10)
                ->by($request->input('username') ?: $request->ip())
                ->response(function (Request $request) {
                    //TODO: Return remaining time in seconds till new requests are going to be accepted
                    return response('throttle', 429);
                });
        });

        RateLimiter::for('ping', function (Request $request) {
            return Limit::perMinute(60)
            ->by($request->ip())
            ->response(function (Request $request) {
                return response('', 429);
            });
        });

        RateLimiter::for('auth-check', function (Request $request) {
            return Limit::perMinute(100)
            ->by($request->ip())
            ->response(function (Request $request) {
                return response('', 429);
            });
        });

        RateLimiter::for('username-generator', function (Request $request) {
            return Limit::perMinute(100)
            ->by($request->ip())
            ->response(function (Request $request) {
                return response('', 429);
            });
        });

        RateLimiter::for('check-username', function (Request $request) {
            return Limit::perMinute(100)
            ->by($request->ip())
            ->response(function (Request $request) {
                return response('', 429);
            });
        });

        RateLimiter::for('sign-up', function (Request $request) {
            return Limit::perMinute(5)
            ->by($request->ip())
            ->response(function (Request $request) {
                return response('', 429);
            });
        });
    }
}
