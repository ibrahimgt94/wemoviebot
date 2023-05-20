<?php

namespace lord\pro;

use Illuminate\Support\ServiceProvider;
use Illuminate\Queue\Capsule\Manager as queue_capsule;
use lord\job\notice;

class queue extends ServiceProvider
{
    public function register()
    {
        $queue = new queue_capsule($this->app);

        $queue->addConnection(config("queue"));

        $queue->setAsGlobal();

        app()->instance("queue", $queue);
    }
}