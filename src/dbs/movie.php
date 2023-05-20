<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class movie extends model
{
    protected $fillable = ["id", "title", "image", "summary", "status"];

    public $timestamps = false;

    public function downs()
    {
        return $this->belongsToMany(down::class);
    }

    public function property()
    {
        return $this->hasOne(property::class);
    }

    public function groups()
    {
        return $this->belongsToMany(group::class);
    }
}