<?php

namespace lord\plg\telg\reply\opts;

/**
 * @property sole $sole
 * @property pack $pack
 * @property among $among
 * @property select $select
 * @property status $status
 * @property query $query
 * @property nums $nums
 * @property addrs $addrs
 * @property fetch $fetch
 * @property listx $list
 * @property list_ary $list_ary
 */
class opts
{
    private array $funcs = [
        "select" => select::class,
        "sole" => sole::class,
        "pack" => pack::class,
        "among" => among::class,
        "status" => status::class,
        "query" => query::class,
        "nums" => nums::class,
        "addrs" => addrs::class,
        "fetch" => fetch::class,
        "list" => listx::class,
        "list_ary" => list_ary::class,
    ];

    public function __get(string $name)
    {
        return collect($this->funcs)->call($name);
    }
}