<?php

namespace lord\aps\panel\user\orgs;

use lord\dbs\user;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\opts;
use lord\plg\telg\reply as telg_reply;
use lord\pro\ears;

class reply extends eadg_reply
{
    public function show_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $search = $this->opts->pack
            ->rule("user.notice.all")
            ->show("user.notice.all", "اطلاع رسانی همگانی")
            ->rule("user.search")
            ->show("user.search", "جستجوی کاربر");

        $users = $this->opts->query->type("info_gls")
            ->table("user")->cell("id", "username")
            ->take(8)->page($page)->chunk(2);

        $backing = $this->opts->sole->rule("back.panel")
            ->show("بازگشت");

        return $this->reply->node("panel.user")->scope($search)
            ->scope($users)->node("panel")->scope($backing);
    }

    public function search_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("user.search.id")
            ->show("user.search.id", "جستجوی ای دی")
            ->rule("user.search.username")
            ->show("user.search.username", "جستجوی نام کاربری");

        $backing = $this->opts->sole->rule("back.user")->show("بازگشت");

        return $this->reply->node("panel.user")->scope($items)->scope($backing);
    }

    public function search_id_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.user.search")->show("بازگشت");

        return $this->reply->node("panel.user")->scope($backing);
    }

    public function search_id_proc_gls($like_id, $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $users = $this->opts->fetch->type("info_gls")->datas(function () use ($like_id) {
            return user::where("id", "like", "%{$like_id}%");
        })->cell("id", "username")->take(5)->page($page)->chunk(2);

        $users = (count($users->get_tmps()) != 0) ? $users : (
            $this->opts->sole->rule("is.not.work")->show("\xF0\x9F\x98\xA2 چیزی یافت نشد ")
        );

        $backing = $this->opts->sole->rule("back.user.search")->show("بازگشت");

        return $this->reply->node("panel.user")->scope($users)->scope($backing);
    }

    public function search_username_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.user.search")->show("بازگشت");

        return $this->reply->node("panel.user")->scope($backing);
    }

    public function search_username_proc_gls($like_id, $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $users = $this->opts->fetch->type("info_gls")->datas(function () use ($like_id) {
            return user::where("username", "like", "%{$like_id}%");
        })->cell("id", "username")->take(5)->page($page)->chunk(2);

        $users = (count($users->get_tmps()) != 0) ? $users : (
            $this->opts->sole->rule("is.not.work")->show("\xF0\x9F\x98\xA2 چیزی یافت نشد ")
        );

        $backing = $this->opts->sole->rule("back.user.search")->show("بازگشت");

        return $this->reply->node("panel.user")->scope($users)->scope($backing);
    }

    public function notice_all_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $notices = $this->opts->query->type("notice_all_gls")
            ->table("notice")->cell("id", "title")
            ->take(8)->page($page)->chunk(1)->enable();

        $backing = $this->opts->sole->rule("back.user")
            ->show("بازگشت");

        return $this->reply->node("panel.user")
            ->scope($notices)->scope($backing);
    }

    public function notice_all_chg_gls($notice)
    {
        $checking = $this->opts->pack
            ->rule("notice.all.cancel")
            ->args("notice.all.cancel", "type", "no")
            ->show("notice.all.cancel", "انصراف")
            ->rule("notice.all.confirm")
            ->args("notice.all.confirm", "type", "yes")
            ->args("notice.all.confirm", "notice", $notice)
            ->show("notice.all.confirm", "ارسال کن");

        return $this->reply->node("panel.user")->scope($checking);
    }

    public function notice_all_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.user.notice.all")
            ->show("بازگشت")->args("query", 1);

        return $this->reply->node("panel.user")->scope($backing);
    }

    public function info_gls($args): telg_reply
    {
        $manages = $this->opts->pack
            ->rule("coin")->show("coin", "مدیریت سکه ها")
            ->rule("notice")->show("notice", "اطلاع رسانی")
            ->chunk(2);

        $admins = config()->get(["admin", "supportAdmin"]);

        (!in_array(ears()->get("user.id"), $admins)) ?: (
            $manages->rule("status")->show("status", "وضعیت کاربر")
        );

        $backing = $this->opts->sole->rule("back.user")
            ->show("بازگشت");

        return $this->reply->node("panel.user")
            ->scope($manages)->scope($backing);
    }

    public function notice_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $notices = $this->opts->query->type("notice_gls")
            ->table("notice")->cell("id", "title")
            ->take(8)->page($page)->chunk(1)->enable();

        $backing = $this->opts->sole->rule("back.user.info")
            ->show("بازگشت")->args("query", ears()->get("user.id"));

        return $this->reply->node("panel.user")->scope($notices)->scope($backing);
    }

    public function notice_chg_gls()
    {
        $checking = $this->opts->pack
            ->rule("notice.chg.cancel")
            ->show("notice.chg.cancel", "انصراف")
            ->rule("notice.chg.confirm")
            ->args("notice.chg.confirm", "notice", lesa()->cals_data_obj->args->query)
            ->show("notice.chg.confirm", "ارسال کن")
            ->chunk(2);

        return $this->reply->node("panel.user")->scope($checking);
    }

    public function notice_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.user.notice")
            ->show("بازگشت")->args("query", 1);

        return $this->reply->node("panel.user")->scope($backing);
    }

    public function coin_gls(): telg_reply
    {
        $types = $this->opts->pack
            ->rule("decrease")->args("decrease", "type", "down")
            ->show("decrease", "کاهش سکه")
            ->rule("increase")->args("increase", "type", "up")
            ->show("increase", "افزایش سکه");

        $backing = $this->opts->sole->rule("back.user.info")
            ->show("بازگشت")->args("query", ears()->get("user.id"));

        return $this->reply->node("panel.user")->scope($types)->scope($backing);
    }

    public function coin_among_gls(string $type, int $coin_count): telg_reply
    {
        $among_start = 1;
        $among_end = 8;
        $among_step = 1;
        $among_chunk = 4;

        $among_end_type = ($type == "down") ? (
        ($coin_count > $among_end) ? $among_end : $coin_count
        ) : $among_end;

        if ($among_end_type != 0) {
            $numbers = $this->opts->among->rule("coin_among_gls")
                ->start($among_start)->end($among_end_type)->step($among_step)
                ->chunk($among_chunk)->args_all(
                    "type", lesa()->cals_data_obj->args->type
                );
        } else {
            $numbers = $this->opts->sole->rule("empty")
                ->show("موجودی سکه کاربر صفر می باشد");
        }

        $backing = $this->opts->sole->rule("back.user.coin")
            ->show("بازگشت")->args("query", ears()->get("user.id"));

        return $this->reply->node("panel.user")->scope($numbers)->scope($backing);
    }

    public function coin_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.user.coin")
            ->show("بازگشت")->args("query", ears()->get("user.id"))
            ->args("type", lesa()->cals_data_obj->args->type);

        return $this->reply->node("panel.user")->scope($backing);
    }

    public function status_gls(): telg_reply
    {
        $checking = $this->opts->pack
            ->rule("status.disable")
            ->show("status.disable", "مسدود کن")
            ->rule("status.enable")
            ->show("status.enable", "آزاد کن")
            ->args("status.enable", "type", "yes")
            ->args("status.disable", "type", "no");

        $backing = $this->opts->sole->rule("back.user.info")
            ->show("بازگشت")->args("query", ears()->get("user.id"));

        return $this->reply->node("panel.user")->scope($checking)->scope($backing);
    }

    public function status_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.user.status")
            ->show("بازگشت")->args("query", ears()->get("user.id"));

        return $this->reply->node("panel.user")->scope($backing);
    }
}