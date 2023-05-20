<?php

namespace lord\plg\map\reply;

/**
 * @property \lord\plg\map\opts\save $save
 * @property \lord\plg\map\opts\cmd $cmd
 */
class base
{
    private array $funcs = [
        "save" => \lord\plg\map\opts\save::class,
        "cmd" => \lord\plg\map\opts\cmd::class,
    ];

    public function __get(string $name)
    {
        return collect($this->funcs)->call($name);
    }
}