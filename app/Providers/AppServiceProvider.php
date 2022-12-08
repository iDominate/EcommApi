<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro('returnResult', function(string $status = "ok",
        string $message = "Success",
        mixed $data = null,
        int $response_code = HttpFoundationResponse::HTTP_OK) {
            $data = [
                "status" => $status,
                "message" => $message,
                "data" => $data
            ];
            return Response::make($data, $response_code);
        });
    }
}
