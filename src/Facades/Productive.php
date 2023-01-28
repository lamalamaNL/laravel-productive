<?php

namespace LamaLama\Productive\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \lamalama\LaravelProductive\LaravelProductive
 */
class Productive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \lamalama\Productive\Productive::class;
    }
}
