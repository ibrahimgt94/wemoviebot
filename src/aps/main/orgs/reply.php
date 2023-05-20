<?php

namespace lord\aps\main\orgs;

use lord\dbs\cog;
use lord\dbs\group;
use lord\dbs\listx;
use lord\dbs\movie;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\reply as telg_reply;
use lord\plg\telg\reply\opts\sole;

class reply extends eadg_reply
{
    public function show_cmd($args = null): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $search = $this->opts->sole->rule("search")->show("جستجوی فیلم");

        $selcs = unserialize(listx::where("name", "gps")->first()->value);

        $take = cog::whereIn("name", [
            "rows.main.gps",
            "chunk.main.gps"
        ])->pluck("value", "name");

        $items = $this->opts->query->type("gps.show.cmd")->table("group")
            ->cell("id", "title")->take($take->get('chunk.main.gps'))
            ->page($page)->hide_page()->chunk($take->get('rows.main.gps'))
            ->when("id", array_values($selcs), "where_in");

        $chanel_dbs = cog::where("name", "channel.uniqid")->first()->value;

        $pp = unserialize($chanel_dbs);

        $chanels = collect(unserialize($chanel_dbs))->map(function ($val) {
            return ($val['status'] == false) ? null : (
                $this->opts->addrs->url($val['url'])
                    ->show(urldecode($val['title']))->chunk(1)
            );
        })->filter();

        $items_other = $this->opts->pack;

        if(cog::where("name", "subset.status")->first()->value){
            $items_other->rule("profile")->show("profile", "پروفایل");
        }

        $items_other->rule("support")
            ->show("support", "پشتیبانی")
            ->rule("help")
            ->show("help", "راهنما");

        $items_other->chunk(2);

        $admin_btn = $this->opts->sole->rule("show")->show("مدیریت ربات");

        $reply_markup = $this->reply->node("main")->scope($search)->scope($items);

        (!$chanels->has("p1")) ?: (
            $reply_markup->addrs($chanels->get("p1"))
        );

        $reply_markup->scope($items_other);

        (!$chanels->has("p2")) ?: (
            $reply_markup->addrs($chanels->get("p2"))
        );

        return $reply_markup->node("panel")->admin($admin_btn);
    }

    public function group_gls(object $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $take = cog::whereIn("name", [
            "chunk.main.gps.chaild",
            "rows.main.gps.chaild"
        ])->pluck("value", "name");

        $groups = $this->opts->query->type("movie_gls")->table("group")
            ->cell("id", "title")->when("parent", $args->id)
            ->chunk($take->get("rows.main.gps.chaild"))
            ->take($take->get("chunk.main.gps.chaild"))->page($page)->enable()
            ->args_page("query", $args->id)
            ->next("صفحه بعدی")->prev("صفحه قبلی");

        $back_main = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scope($groups)->scopes($back_main);
    }

    private function back_type_parent(): sole
    {
        return $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);
    }

    private function back_type_chaild(): sole
    {
        $info_gps = group::where("id", ears()->get("query"))->first();

        return $this->opts->sole->rule("back.group.x2")
            ->show("بازگشت")->chunk(1)
            ->args("query", $info_gps->parent);
    }

    public function movie_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $take = cog::whereIn("name", [
            "chunk.main.gps.video",
            "rows.main.gps.video"
        ])->pluck("value", "name");

        $movies = $this->opts->fetch->type("down_gls")
            ->chunk($take->get("rows.main.gps.video"))
            ->take($take->get("chunk.main.gps.video"))
            ->page($page)->datas(function () {
                return group::where("id", ears()->get("query"))->first()->movies();
            })->cell("id", "title");

        $ptype = ears()->get("ptype");

        ears()->set("movie.gps.id", lesa()->cals_data_obj->args->query);

        $back_btns = match ($ptype) {
            "parent" => $this->back_type_parent(),
            "chaild" => $this->back_type_chaild(),
        };

        return $this->reply->node("main")->scope($movies)->scope($back_btns);
    }

    public function down_gls($downs, $is_search): telg_reply
    {
        $addrs = $this->opts->addrs;

        $addrs_two = collect($downs)->map(function ($down) use ($addrs) {
            return $addrs->url($down->addrs)->show($down->title)->get_tmps();
        });

        $addrs->set_gps($addrs_two);

        if ($is_search) {
            $back_part = $this->opts->sole->rule("back.main")
                ->show("بازگشت")->chunk(1);
        } else {
            $back_part = $this->opts->sole->rule("back.movie")
                ->show("بازگشت")->chunk(1)
                ->args("query", ears()->get("movie.gps.id"));
        }

        return $this->reply->node("main")
            ->addrs($addrs)->scopes($back_part);
    }

    public function proposed_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scopes($backing);
    }

    public function popular_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scopes($backing);
    }

    public function help_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scope($backing);
    }

    public function profile_gls($bot_id, $user_id): telg_reply
    {
        $subset_link = $this->opts->addrs
            ->url("https://t.me/{$bot_id}")
            ->show("لینک زیر مجموعه گیری")->args("start", $user_id);

        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scope($backing);
    }

    public function support_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scope($backing);
    }

    public function search_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.main")
            ->show("بازگشت")->chunk(1);

        return $this->reply->node("main")->scope($backing);
    }

    public function search_proc_gls($search, $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $take = cog::whereIn("name", [
            "chunk.main.gps.search",
            "rows.main.gps.search"
        ])->pluck("value", "name");

        $movies = $this->opts->fetch->type("down_gls")
            ->chunk($take->get("rows.main.gps.search"))
            ->take($take->get("chunk.main.gps.search"))
            ->page($page)->datas(function () use ($search) {
                return movie::where("title", "like", "%{$search}%");
            })->cell("id", "title")->args("search", true)
            ->prev("صفحه قبلی")->next("صفحه بعدی");

        $movies = (count($movies->get_tmps()) != 0) ? $movies : (
            $this->opts->sole->rule("is.not.work")->show("\xF0\x9F\x98\xA2 چیزی یافت نشد ")
        );

        $back_btns = $this->back_type_parent();

        return $this->reply->node("main")->scope($movies)->scope($back_btns);
    }
}