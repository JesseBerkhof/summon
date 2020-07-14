<?php

declare(strict_types=1);

namespace Arctic\Wraith;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Arctic\Wraith\Wraith
 */
class WraithFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'wraith';
    }
}
