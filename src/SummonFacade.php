<?php

declare(strict_types=1);

namespace JesseBerkhof\Summon;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JesseBerkhof\Summon\Summon
 */
final class SummonFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'summon';
    }
}
