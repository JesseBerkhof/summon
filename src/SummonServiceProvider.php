<?php

declare(strict_types=1);

namespace JesseBerkhof\Summon;

use JesseBerkhof\Summon\Commands\SummonList;
use JesseBerkhof\Summon\Commands\SummonNew;
use Illuminate\Support\ServiceProvider;

class SummonServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole())
        {
            $this->commands([
                SummonNew::class,
                SummonList::class,
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
