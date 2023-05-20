<?php

namespace lord\pro;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class str extends ServiceProvider
{
    public function register()
    {
        $this->app->bind("str", function ($app){
            return $app->make(\Illuminate\Support\Str::class);
        });
    }
}