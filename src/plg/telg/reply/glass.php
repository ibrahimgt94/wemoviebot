<?php

namespace lord\plg\telg\reply;

use lord\plg\telg\reply\opts\node;
use lord\plg\telg\reply\opts\sole;

/**
 * @property node $node
 * @property sole $sole
 */
class glass
{
    private array $funcs = [
        "sole" => sole::class,
        "node" => node::class,
    ];

    public function __get(string $name)
    {
        return collect($this->funcs)->call($name);
    }
}