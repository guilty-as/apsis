<?php

namespace Guilty\Apsis;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Guilty\Apsis\Factory
 */
class ApsisFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'apsis';
    }
}