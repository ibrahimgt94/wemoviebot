<?php

namespace lord\fac;

use Illuminate\Support\Facades\Facade;
use lord\plg\telg\opts\send\mesg;

/**
 * @method void setWebhook()
 * @method void sendMesg(mesg $mesg)
 *
 */
class telg extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \lord\plg\telg\telg::class;
    }
}