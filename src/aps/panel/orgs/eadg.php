<?php

namespace lord\aps\panel\orgs;

use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;

class eadg extends eage_clas
{
    public function show_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls()
        );
    }
}