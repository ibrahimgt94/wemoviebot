<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class property extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;

    protected $table = "propertys";

    public function scopeGet_pros($dbs, $name)
    {
        return group::whereIn(
            "id", unserialize($dbs->first()->{$name})
        )->get()->pluck("title")->join(" - ");
    }
}