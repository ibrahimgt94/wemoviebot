<?php

namespace lord\plg\telg;

use lord\plg\telg\reply as reeply;
use lord\plg\telg\reply\opts\opts as opts;

class eadg_reply
{
    protected reeply $reply;

    protected opts $opts;

    public function __construct()
    {
        $this->reply = new reeply();

        $this->opts = new opts();
    }
}