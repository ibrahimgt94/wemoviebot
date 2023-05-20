<?php

namespace lord\fac\plg\map;

use Illuminate\Support\Facades\Facade;

/**
 * @method void regis_new_user()
 *
 */
class auth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \lord\plg\map\auth::class;
    }
}