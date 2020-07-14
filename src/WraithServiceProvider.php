<?php

declare(strict_types=1);

namespace Arctic\Wraith;

use Arctic\Wraith\Commands\Summon;
use Illuminate\Support\ServiceProvider;

class WraithServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                Summon::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/wraith.php' => config_path('wraith.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../app/Console/Commands' => base_path('Commands/Wraith'),
            ], 'commands');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/wraith.php', 'wraith'
        );
    }
}
