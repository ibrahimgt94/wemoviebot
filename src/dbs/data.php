<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class data extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;

    protected $table = "datas";

    public function scopeGet_value_data($query, $name)
    {
        $hand = $query->where("name", $name);

        return $hand->exists() ? $this->get_value($hand) : false;
    }

    public function scopeSet_value_data($query, $name, $value)
    {
        return $query->insert(compact("name", "value"));
    }

    private function get_value($hand)
    {
        return collect(unserialize($hand->first()->value))
            ->get(lesa()->cals_data_obj->args->query);
    }
}