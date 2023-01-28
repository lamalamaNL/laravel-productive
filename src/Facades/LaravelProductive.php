<?php

namespace lamalama\LaravelProductive\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \lamalama\LaravelProductive\LaravelProductive
 */
class LaravelProductive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \lamalama\LaravelProductive\LaravelProductive::class;
    }
}
