<?php

if (! function_exists('productive')) {
    /**
     * @return \LamaLama\Productive\Wrappers\ProductiveApiWrapper
     */
    function productive()
    {
        return app('productive');
    }
}
