<?php

namespace lord\aps\panel\orgs;

use lord\plg\telg\eadg_reply;
use lord\plg\telg\reply as telg_reply;

class reply extends eadg_reply
{
    public function show_gls(): telg_reply
    {
        return $this->reply->group([
            "panel.group" => $this->opts->sole->rule("group")->show("دسته بندی"),
            "panel.user" => $this->opts->sole->rule("user")->show("کاربران"),
            "panel.cog" => $this->opts->sole->rule("cog")->show("تنظیمات"),
            "panel.movie" => $this->opts->sole->rule("movie")->show("فیلم ها"),
            "panel.notice" => $this->opts->sole->rule("notice")->show("اطلاع رسانی"),

        ], 2)->node("main")->scope(
            $this->opts->sole->rule("back.main")->show("بازگشت")
        );
    }
}