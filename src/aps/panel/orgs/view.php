<?php

namespace lord\aps\panel\orgs;

use lord\plg\telg\view as telg_view;

class view extends telg_view
{
    public function show_gls(): string
    {
        return $this->text("پنل مدیریتی")->text(
            "در این بخش میتوانید تنضیمات خود را بر روی ربات مدیریت کنید"
        )->get();
    }
}