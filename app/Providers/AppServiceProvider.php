<?php

namespace App\Providers;

use http\Env\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ResponseFactory::macro('api', function ($data , $message = null, $error=0, $status = 200) {
            $format = [
                'status' => $status,
                'error' => $error,
                'message' => $message,
                'data' => $data,
            ];
            return response()->json($format, $status);
        });

        ResponseFactory::macro('apiError', function ($message = null, $error=1, $status = 200) {
            $format = [
                'status' => $status,
                'error' => $error,
                'message' => $message,
            ];
            return response()->json($format, $status);
        });
    }
}
