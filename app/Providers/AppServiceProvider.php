<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //商用環境以外だった場合、SQLログを出力させます
        if (config('app.env') !== 'production') {
            \DB::listen(function ($query) {
                \Log::info("Query Time:{$query->time}s] $query->sql");
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
