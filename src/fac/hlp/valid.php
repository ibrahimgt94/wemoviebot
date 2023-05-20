<?php

namespace lord\fac;

use Illuminate\Support\Facades\Facade;
use lord\hlp\valid as hlp_valid;

/**
 * @method hlp_valid rules(string $rules)
 * @method hlp_valid fails()
 * @method hlp_valid reply()
 * @method mixed runing()
 *
 */
class valid extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return hlp_valid::class;
    }
}