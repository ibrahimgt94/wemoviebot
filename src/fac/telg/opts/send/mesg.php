<?php

namespace lord\fac\telg\opts\send;

use Illuminate\Support\Facades\Facade;

/**
 * @method self chat_id(int $chat_id)
 * @method self text(string $text)
 *
 */
class mesg extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \lord\plg\telg\opts\send\mesg::class;
    }
}