<?php

namespace Lord\plg\telg;

use Exception;
use lord\plg\telg\opts\send\mesg;
use lord\plg\telg\opts\send\mesg as send_mesg;
use lord\plg\telg\opts\set\web_hook;
use lord\plg\telg\opts\send\photo as send_photo;
use lord\plg\telg\opts\edit\mesg as edit_mesg;
use lord\plg\telg\opts\delete\mesg as dele_mesg;
use lord\plg\telg\opts\get\file as get_file;

/**
 * @property web_hook $set_web_hook
 * @property send_mesg $send_mesg
 * @property edit_mesg $edit_mesg
 * @property send_photo $send_photo
 * @property dele_mesg $dele_mesg
 * @property get_file $get_file
 */
class telg
{
    public function __get(string $func)
    {
        return (! method_exists($this, $func)) ? (
            $this->throw_func($func)
        ) : call_user_func([$this, $func]);
    }

    private function throw_func(string $func): void
    {
        throw new exception("not exists property {$func} in telg class");
    }

    private function send_mesg(): send_mesg
    {
        return app()->make(\lord\plg\telg\opts\send\mesg::class);
    }

    private function send_photo(): send_photo
    {
        return app()->make(\lord\plg\telg\opts\send\photo::class);
    }

    private function edit_mesg(): edit_mesg
    {
        return app()->make(\lord\plg\telg\opts\edit\mesg::class);
    }

    private function dele_mesg(): dele_mesg
    {
        return app()->make(\lord\plg\telg\opts\delete\mesg::class);
    }

    private function get_file(): get_file
    {
        return app()->make(\lord\plg\telg\opts\get\file::class);
    }

    private function set_web_hook(): web_hook
    {
        return app()->make(\lord\plg\telg\opts\set\web_hook::class);
    }
}