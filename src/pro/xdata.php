<?php

namespace lord\pro;

use Illuminate\Support\ServiceProvider;

class xdata extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton("xdata", function (){
            return collect([
                "node" => collect(),
                "maps" => collect(),
            ]);
        });
    }
}