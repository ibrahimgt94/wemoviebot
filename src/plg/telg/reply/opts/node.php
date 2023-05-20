<?php

namespace lord\plg\telg\reply\opts;

/**
 * @property opts $main
 * @property opts $panel
 */
class node
{
    public function __get(string $node)
    {
        rdata()->get("node")->put("flat", $node)
            ->put("hash", hlps()->route($node));

        return reflect(opts::class)->newInstance();
    }
}