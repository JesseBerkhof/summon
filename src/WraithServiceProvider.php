<?php

declare(strict_types=1);

namespace Arctic\Wraith;

use Illuminate\Support\ServiceProvider;

class WraithServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (!$this->app->runningInConsole())
        {
            $this->publishes([
                __DIR__.'/../config/wraith.php' => config_path('wraith.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../app/Console/Commands' => base_path('Commands/Wraith'),
            ], 'views');
        }
    }
}
