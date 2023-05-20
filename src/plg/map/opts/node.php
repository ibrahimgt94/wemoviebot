<?php

namespace lord\plg\map\opts;

/**
 * @property \lord\plg\map\reply $main
 * @property \lord\plg\map\reply $panel
 * @property \lord\plg\map\reply $panel_user
 * @property \lord\plg\map\reply $panel_group
 * @property \lord\plg\map\reply $panel_movie
 * @property \lord\plg\map\reply $panel_cog
 * @property \lord\plg\map\reply $panel_notice
 */
class node
{
    public function __get(string $node)
    {
        $node = str()->of($node)->replace("_", ".");

        $node = "{$node}.orgs.eadg";

        xdata()->get("node")->put("flat", $node)
            ->put("hash", hlps()->route($node));

        return reflect(
            \lord\plg\map\reply::class
        )->newInstance();
    }
}