<?php

namespace lord\plg\map;

use Illuminate\Support\Collection as collect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use lord\dbs\tmp;
use lord\dbs\user;
use lord\pro\xdata;

class map
{
    private int $ttl = 60;

    public function booting(): void
    {
        $this->set_web_hook();

        lesa()->booting();

        $this->load_telg_map_file();
    }

    private function set_web_hook(): void
    {
       # telg()->set_web_hook->url()->contact()->exec();
    }
    
    private function load_telg_map_file(): void
    {
        xroute()->dispach();

        include_once store()->path("/map/telg.php");

        xroute()->execute();
    }
}