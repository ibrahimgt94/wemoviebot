<?php

namespace lord\plg\map\reply;

/**
 * @property \lord\plg\map\opts\sole $sole
 * @property \lord\plg\map\opts\query $query
 * @property \lord\plg\map\opts\pack $pack
 * @property \lord\plg\map\opts\among $among
 * @property \lord\plg\map\opts\select $select
 * @property \lord\plg\map\opts\nums $nums
 * @property \lord\plg\map\opts\select $status
 * @property \lord\plg\map\opts\list_ary $list_ary
 */
class glass
{
    private array $funcs = [
        "sole" => \lord\plg\map\opts\sole::class,
        "query" => \lord\plg\map\opts\query::class,
        "pack" => \lord\plg\map\opts\pack::class,
        "among" => \lord\plg\map\opts\among::class,
        "select" => \lord\plg\map\opts\select::class,
        "nums" => \lord\plg\map\opts\nums::class,
        "status" => \lord\plg\map\opts\select::class,
        "list_ary" => \lord\plg\map\opts\list_ary::class,
    ];

    public function __get(string $name)
    {
        return collect($this->funcs)->call($name);
    }
}