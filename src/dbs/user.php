<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class user extends model
{
    protected $fillable = [
        "id", "username", "fname", "lname", "coin",
        "sex", "age", "parent", "subset", "payment", "status"
    ];

    public $timestamps = false;

    public function tmp()
    {
        return $this->hasOne(\lord\dbs\tmp::class);
    }
}