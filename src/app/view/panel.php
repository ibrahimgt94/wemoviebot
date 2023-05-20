<?php

namespace lord\app\view;

use lord\plg\telg\view;

class panel extends view
{
    public function show(): string
    {
        return $this->text("panel")
            ->text("panel is working")->get();
    }
}