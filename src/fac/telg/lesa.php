<?php

namespace lord\fac\telg;

use \Illuminate\Support\Facades\Facade;

/**
 * @method voide booting()
 * @method string get_updates()
 * @method object get_json_updates()
 * @method mixed getBindKey(string $key)
 * @method array getBinds()
 *
 * @property int chat_id
 */
class lesa extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \lord\plg\telg\lesa::class;
    }
}