<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class group extends model
{
    protected $fillable = ["id", "name", "title", "parent", "status"];

    public $timestamps = false;

    public function movies()
    {
        return $this->belongsToMany(movie::class);
    }
}