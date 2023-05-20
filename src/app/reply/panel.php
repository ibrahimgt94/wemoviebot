<?php

namespace lord\app\reply;

use lord\dbs\movie;
use lord\dbs\group;
use lord\dbs\movie_serie;
use lord\plg\telg\reply;
use lord\plg\telg\reply\opts\sole;
use Illuminate\Support\Collection as collect;

class panel extends edge
{
    public function users(): reply
    {
        $search = $this->opts->sole->rule("search")
            ->show("search")->chunk(1);

        $user_list = $this->opts->query->type("info_user")
            ->table("user")->cell("id", "username")
            ->take(9)->page(0)->chunk(2)->enable();

        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("user")->scope($search)
            ->node("panel")->scope($user_list)->node("main")->scope($back_panel);
    }

    public function info_user(): reply
    {
        $infos = $this->opts->pack->rule("coin")
            ->rule("status")->chunk(2);

        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("panel")->scope($infos)->node("main")->scope($back_panel);
    }

    public function info_user_coin(): reply
    {
        $coins = $this->opts->pack->rule("increase")
            ->rule("decrease")->chunk(2);

        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("panel")->scope($coins)
            ->node("main")->scope($back_panel);
    }

    public function info_user_coin_chg(): reply
    {
        $betws = $this->opts->among->rule("info_user_coin_proc")
            ->start(1)->end(8)->step(1)->chunk(4);

        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("panel")
            ->scope($betws)->node("main")->scope($back_panel);
    }

    public function info_user_coin_proc(): reply
    {
        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("main")->scope($back_panel);
    }

    public function info_user_status(): reply
    {
        $sta_btns = $this->opts->pack->rule("enable")->rule("disable")
            ->chunk(2);

        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("panel")->scope($sta_btns)
            ->node("main")->scope($back_panel);
    }

    public function info_user_status_proc(): reply
    {
        $back_panel = $this->opts->sole->rule("back.panel")
            ->show("back panel")->chunk(1);

        return $this->reply->node("main")->scope($back_panel);
    }
}