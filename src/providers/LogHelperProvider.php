<?php


namespace Huyct\TelegramHelper\providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class LogHelperProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/loghelper.php' => config_path('loghelper.php'),
        ], 'loghelper');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/loghelper.php', 'loghelper'
        );
    }
}