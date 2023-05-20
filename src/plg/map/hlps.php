<?php

namespace lord\plg\map;

use lord\dbs\group;

class hlps
{
    public function route()
    {
        return str()->of(
            hash("sha1", implode(".", func_get_args()))
        )->substr(12, 9)->__toString();
    }

    public function get_group_name(array $list)
    {
        return group::whereIn("id", $list)->get();
    }

    public function convert_serialize_to_string($serialize): string
    {
        $list_data = $this->get_group_name(unserialize($serialize));
        
        return $list_data->pluck("title")->join(" , ");
    }
}