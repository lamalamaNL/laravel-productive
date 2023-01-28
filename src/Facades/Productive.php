<?php

namespace LamaLama\Productive\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \LamaLama\LaravelProductive\LaravelProductive
 */
class Productive extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \LamaLama\Productive\Productive::class;
    }
}
