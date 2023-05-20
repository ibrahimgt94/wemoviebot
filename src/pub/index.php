<?php

require "../../vendor/autoload.php";

use Illuminate\Support\Facades\App;
use Illuminate\Foundation\Application;

$ios = Application::getInstance();

App::setFacadeApplication($ios);

$ios->setBasePath(dirname(__dir__));

$ios->register(\Illuminate\Foundation\Providers\ArtisanServiceProvider::class);

$ios->make(\lord\plg\bot\setup::class)->handel();
