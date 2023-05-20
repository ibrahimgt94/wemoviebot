<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class queue extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;
}