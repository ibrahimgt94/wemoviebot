<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class cog extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;
}