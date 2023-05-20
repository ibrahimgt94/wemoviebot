<?php

namespace lord\pro;

use Illuminate\Support\ServiceProvider;

class lesa extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(\lord\plg\telg\lesa::class);
    }
}