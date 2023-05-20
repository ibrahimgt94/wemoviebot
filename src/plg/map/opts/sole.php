<?php

namespace lord\plg\map\opts;

class sole extends edge
{
    public function __destruct()
    {
        xroute()->push_rule_data($this->datas);
    }
}