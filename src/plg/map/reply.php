<?php

namespace lord\plg\map;

/**
 * @property \lord\plg\map\reply\base $base
 * @property \lord\plg\map\reply\glass $glass
 * @property \lord\plg\map\reply\line $line
 */
class reply
{
    private array $lists = [
        "base" => \lord\plg\map\reply\base::class,
        "glass" => \lord\plg\map\reply\glass::class,
        "line" => \lord\plg\map\reply\line::class,
    ];

    public function __get(string $name)
    {
        return collect($this->lists)->call($name);
    }
}