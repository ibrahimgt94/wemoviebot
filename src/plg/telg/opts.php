<?php

namespace lord\plg\telg;

use lord\plg\telg\telg;
use lord\plg\telg\opts\answer\callback\query;

/**
 * @property telg $telg
 * @property query $query
 */
class opts
{
    private array $lists = [
        "telg" => telg::class,
        "query" => query::class,
    ];

    public function __get(string $name)
    {
        return collect($this->lists)->call($name);
    }
}