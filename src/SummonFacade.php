<?php

declare(strict_types=1);

namespace Arctic\Summon;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Arctic\Summon\Summon
 */
class SummonFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'summon';
    }
}
