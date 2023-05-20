<?php

namespace lord\app\reply;

use lord\dbs\movie;
use lord\dbs\group;
use lord\dbs\movie_serie;
use lord\plg\telg\reply;
use lord\plg\telg\reply\opts\sole;
use Illuminate\Support\Collection as collect;

class main extends edge

{
    public function show(): reply
    {
        $search = $this->opts->sole->rule("search")->show("search");

        $packe_head = $this->opts->pack->rule("popular")
            ->rule("proposed")->chunk(2);

        $packe_info = $this->opts->pack->rule("actor")->rule("director")
            ->rule("writer")->rule("year")->chunk(2);

        $chanel = $this->opts->addrs->url("https://t.me/ghadim56")
            ->show("channel")->chunk(1);

        $support_help = $this->opts->pack->rule("help")->rule("support")->chunk(2);

        $manage_robat = $this->opts->sole->rule("panel")->show("management");

        return $this->reply->node("main")->scope($search)
            ->scope($packe_head)->scope($packe_info)->addrs($chanel)
            ->scope($support_help)->admin($manage_robat);
    }

    public function panel(): reply
    {
        $list_btns = $this->opts->pack->rule("user")
            ->rule("movie")->rule("cogs")
            ->rule("group")->chunk(2);

        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("panel")->scope($list_btns)
            ->node("main")->scopes($back_main);
    }

    public function groups(object $args): reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page);

        $groups = $this->opts->query->type("movie_gps")->table("group")
            ->cell("id", "name")->when("parent", $args->id)
            ->chunk($args->chunk)->take($args->take)->page($page)->enable();

        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scope($groups)->scopes($back_main);
    }

    private function back_type_parent(): sole
    {
        return $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);
    }

    private function back_type_chaild(): sole
    {
        $info_gps = group::where("id", ears()->get("group"))->first();

        $name_gps = group::where("id", $info_gps->parent)->first()->name;

        return $this->opts->sole->rule("back.group.{$name_gps}")
            ->show("back group")->chunk(1);
    }

    public function movie_gps(): reply
    {
        $movies = $this->opts->fetch->type("down_gps")->chunk(1)
            ->take(5)->page(0)->datas(function () {
                return group::where("id", ears()->get("group"))->first()->movies();
            })->cell("id", "title");

        $ptype = ears()->get("ptype");

        $back_btns = match ($ptype)
        {
            "parent" => $this->back_type_parent(),
            "chaild" => $this->back_type_chaild(),
        };

        return $this->reply->node("main")->scope($movies)->scope($back_btns);
    }

    public function down_gps(): reply
    {
        $part = ears()->get("part");

        $back_part = $this->opts->sole->rule("back.movie")
            ->show("back movie")->chunk(1);

        return $this->reply->node("main")->scopes($back_part);
    }

    public function help(): reply
    {
        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scopes($back_main);
    }

    public function support(): reply
    {
        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scopes($back_main);
    }

    public function search(): reply
    {
        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scopes($back_main);
    }

    public function proposed(): reply
    {
        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scopes($back_main);
    }

    public function popular(): reply
    {
        $back_main = $this->opts->sole->rule("back.main")
            ->show("back main")->chunk(1);

        return $this->reply->node("main")->scopes($back_main);
    }
}