<?php

namespace lord\app\view;

use lord\plg\telg\view;

class main extends view
{
    public function show(): string
    {
        return $this->text("welcome")
            ->text("robat is working")->get();
    }

    public function panel(): string
    {
        return $this->text("welcome")
            ->text("admin panels")->get();
    }
}