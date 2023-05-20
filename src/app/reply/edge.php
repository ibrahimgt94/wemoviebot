<?php

namespace lord\app\reply;

use lord\dbs\tmp;
use lord\plg\telg\reply;
use lord\plg\telg\reply\opts\opts;
use Illuminate\Support\Collection as collect;

abstract class edge
{
    protected reply $reply;

    protected opts $opts;

    public function __construct()
    {
        $this->reply = app()->make(reply::class);

        $this->opts = app()->make(opts::class);
    }
}