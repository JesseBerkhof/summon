<?php

declare(strict_types=1);

namespace Arctic\Summon;

use Arctic\Summon\Commands\Summon;
use Illuminate\Support\ServiceProvider;

class SummonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                Summon::class,
            ]);

            $this->publishes([
                __DIR__.'/../config/summon.php' => config_path('summon.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../app/Console/Commands' => base_path('Commands/Summon'),
            ], 'commands');
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/config/summon.php', 'summon'
        );
    }
}
