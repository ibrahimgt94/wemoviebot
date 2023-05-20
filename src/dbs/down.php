<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class down extends model
{
    protected $fillable = ["id", "title", "addrs", "status"];

    public $timestamps = false;
}