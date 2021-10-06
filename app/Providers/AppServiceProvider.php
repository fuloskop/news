<?php

namespace App\Providers;

use App\Logger\Base\Logger;
use App\Logger\Contact\LoggerInterface;
use App\Repositories\LogsRepository;
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
        $this->app->singleton(LoggerInterface::class,Logger::class);
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
