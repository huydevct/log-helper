<?php


namespace Huyct\TelegramHelper\providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;

class TelegramHelperProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/telegramhelper.php' => config_path('telegramhelper.php'),
        ], 'telegramhelper_config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/telegramhelper.php', 'telegramhelper'
        );
    }
}