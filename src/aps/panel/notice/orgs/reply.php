<?php

namespace lord\aps\panel\notice\orgs;

use lord\dbs\user;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\reply as telg_reply;
use lord\pro\ears;

class reply extends eadg_reply
{
    public function show_gls($args): telg_reply
    {
        ears()->reset();

        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->pack->rule("add.notice")
            ->show("add.notice", "افزودن اطلاع رسانی جدید")
            ->chunk(1);

        $list = $this->opts->query->type("edit.notice")->table("notice")
            ->cell("id", "title")->take(8)->page($page)->chunk(1);

        $backing = $this->opts->sole->rule("back.panel")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($items)
            ->scope($list)->node("panel")->scope($backing);
    }

    public function wait_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $list = $this->opts->query->type("wait.gls")
            ->table("job")->cell("id", "username", true)
            ->take(8)->page($page)->chunk(1);

        $backing = $this->opts->sole->rule("back.notice.edit")
            ->args("query", ears()->get("notice.id"))
            ->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($list)->scope($backing);
    }

    public function wait_search_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice.edit")
            ->args("query", ears()->get("notice.id"))
            ->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function wait_search_proc_gls($job_finds, $args)
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $list = $this->opts->query->type("wait.gls")
            ->table("job")->when("id", $job_finds, "where_in")
            ->cell("id", "username", true)
            ->take(8)->page($page)->chunk(1);

        $backing = $this->opts->sole->rule("back.notice.edit")
            ->args("query", ears()->get("notice.id"))
            ->show("بازگشت");

        return $this->reply->node("panel.notice")
            ->empty_scope($list)->scope($backing);
    }

    public function wait_show_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("wait.delete")
            ->show("wait.delete", "حذف این اطلاع رسانی از صف")
            ->rule("wait.resend")
            ->show("wait.resend", "ارسال پیام اطلاع رسانی به این کاربر")
            ->chunk(1);

        $backing = $this->opts->sole->rule("back.wait.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($items)->scope($backing);
    }

    public function wait_resend_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("wait.resend.confirm")
            ->show("wait.resend.confirm", "پیام اطلاع رسانی را ارسال کن")
            ->rule("back.wait.notice.show")
            ->args("back.wait.notice.show", "query", ears()->get("notice.wait.id"))
            ->show("back.wait.notice.show", "بازگشت")
            ->chunk(1);

        return $this->reply->node("panel.notice")->scope($items);
    }

    public function wait_resend_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.wait.notice.show")
            ->args("query", ears()->get("notice.wait.id"))->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function wait_delete_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("wait.delete.confirm")
            ->show("wait.delete.confirm", "این پیام اطلاع رسانی از صف حذف کن")
            ->rule("back.wait.notice.show")
            ->args("back.wait.notice.show", "query", ears()->get("notice.wait.id"))
            ->show("back.wait.notice.show", "بازگشت")
            ->chunk(1);

        return $this->reply->node("panel.notice")->scope($items);
    }

    public function wait_delete_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.wait.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function add_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function add_title_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function add_body_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("add.status.proc1")
            ->show("add.status.proc1", "غیرفعال کن")
            ->args("add.status.proc1", "type", "off")
            ->rule("add.status.proc")
            ->show("add.status.proc", "فعال کن")
            ->args("add.status.proc", "type", "on");

        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($items)->scope($backing);
    }

    public function add_status_gls(): telg_reply
    {
        $items = $this->opts->sole
            ->rule("add.confirm")
            ->show("اطلاع رسانی را دخیره کن");

        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($items)->scope($backing);
    }

    public function add_save_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_gls(): telg_reply
    {
        ears()->set("notice.id", lesa()->cals_data_obj->args->query);

        $items = $this->opts->pack
            ->rule("edit.body")->show("edit.body", "ویرایش توضیحات")
            ->rule("edit.title")->show("edit.title", "ویرایش عنوان")
            ->rule("edit.delete")->show("edit.delete", "حذف اطلاع رسانی")
            ->rule("edit.status")->show("edit.status", "ویرایش وضعیت");

        $item_title = $this->opts->pack
            ->rule("is.not.working")
            ->show("is.not.working", "اطلاعات لیست انتظار اطلاع رسانی")
            ->chunk(1);

        $items_wait = $this->opts->pack
            ->rule("user.job.show")
            ->show("user.job.show", "لیست کاربران")
            ->args("user.job.show", "query", ears()->get("notice.wait.id"))
            ->rule("search.user.job")
            ->show("search.user.job", "جستجوی کاربر")
            ->args("search.user.job", "notice", ears()->get("notice.wait.id"));

        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($items)
            ->scope($item_title)->scope($items_wait)->scope($backing);
    }

    public function delete_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("back.notice.edit")->show("back.notice.edit", "بازگشت")
            ->args("back.notice.edit", "query", ears()->get("notice.id"))
            ->rule("delete.confirm")->show("delete.confirm", "حذف کن");

        return $this->reply->node("panel.notice")->scope($items);
    }

    public function delete_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_title_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice.edit")
            ->show("بازگشت")->args("query", ears()->get("notice.id"));

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_title_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.notice.edit.title")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_body_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.notice.edit")
            ->show("بازگشت")->args("query", ears()->get("notice.id"));;

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_body_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.notice.edit.body")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }

    public function edit_status_gls($status): telg_reply
    {
        $items = $this->opts->pack;

        if ($status == true) {
            $items->rule("edit.status.proc")
                ->show("edit.status.proc", "غیرفعال کن")
                ->args("edit.status.proc", "type", "off");
        } else {
            $items->rule("edit.status.proc")
                ->show("edit.status.proc", "فعال کن")
                ->args("edit.status.proc", "type", "on");
        }

        $backing = $this->opts->sole->rule("back.notice.edit")
            ->show("بازگشت")->args("query", ears()->get("notice.id"));;

        return $this->reply->node("panel.notice")->scope($items)->scope($backing);
    }

    public function edit_status_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.notice.edit.status")->show("بازگشت");

        return $this->reply->node("panel.notice")->scope($backing);
    }
}