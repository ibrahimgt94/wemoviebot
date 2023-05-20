<?php

namespace lord\pro;

use Illuminate\Support\ServiceProvider;

class hlps extends ServiceProvider
{
    public function register()
    {
        $this->app->bind("hlps", \lord\plg\map\hlps::class);
    }
}