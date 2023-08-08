<?php

namespace App\Providers;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class FolioServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Folio::route(
            path: resource_path('views/pages'),
            uri: 'de',
            middleware: [
                '*' => [
                    function(Request $request, Closure $next) {
                        App::setLocale('de');

                        return $next($request);
                    },
                ],
            ],
        );

        Folio::route(
            path: resource_path('views/pages'),
            uri: 'en',
            middleware: [
                '*' => [
                    function(Request $request, Closure $next) {
                        App::setLocale('en');

                        return $next($request);
                    },
                ],
            ],
        );

        Route::get('{path}', function() {
            return redirect('/en/'.request()->path());
        })
        ->where('path', '^(?!\/(?:en|de)\/).*');
    }
}
