<?php

namespace lord\pro;

use Illuminate\Support\ServiceProvider;

class rdata extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton("rdata", function (){
            return collect([
                "node" => collect(),
                "maps" => collect([
                    "node" => collect(),
                    "rule" => collect(),
                    "args" => collect(),
                ]),
            ]);
        });
    }
}