<?php

namespace lord\aps\panel\group\orgs;

use lord\dbs\group;
use lord\dbs\tmp;
use lord\dbs\user;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\opts;
use lord\plg\telg\reply as telg_reply;

class reply extends eadg_reply
{
    public function show_gls(): telg_reply
    {
        $search = $this->opts->sole->rule("search")->show("جستجوی دسته بندی");

        $items = $this->opts->pack->rule("add")
            ->show("add", "افزودن دسته بندی")->rule("list")
            ->show("list", "لیست دسته بندی ها");

        $backing = $this->opts->sole->rule("back.panel")
            ->show("بازگشت");

        return $this->reply->node("panel.group")->scope($search)->scope($items)
            ->node("panel")->scope($backing);
    }

    public function search_gls()
    {
        $items = $this->opts->pack->rule("search.by.name")
            ->show("search.by.name", "جستجو با عنوان انگلیسی")
            ->rule("search.by.title")
            ->show("search.by.title", "جستجو با عنوان فارسی");

        $backing = $this->opts->sole->rule("back.group")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($items)->scope($backing);
    }

    public function search_by_name_gls()
    {
        $backing = $this->opts->sole->rule("back.search")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($backing);
    }

    public function search_by_title_gls()
    {
        $backing = $this->opts->sole->rule("back.search")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($backing);
    }

    public function search_by_name_proc_gls($text, $args)
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $lists = $this->opts->fetch->type("list_gls")->datas(function () use ($text) {
            return group::where("name", "like", "%{$text}%");
        })->cell("id", "title")->take(8)->page($page)
            ->chunk(2);

        $lists = (count($lists->get_tmps()) != 0) ? $lists : (
            $this->opts->sole->rule("is.not.work")->show("\xF0\x9F\x98\xA2 چیزی یافت نشد ")
        );

        $backing = $this->opts->sole->rule("back.search")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($lists)->scope($backing);
    }

    public function search_by_title_proc_gls($text, $args)
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $lists = $this->opts->fetch->type("list_gls")->datas(function () use ($text) {
            return group::where("title", "like", "%{$text}%");
        })->cell("id", "title")->take(8)->page($page)
            ->chunk(2);

        $lists = (count($lists->get_tmps()) != 0) ? $lists : (
            $this->opts->sole->rule("is.not.work")->show("\xF0\x9F\x98\xA2 چیزی یافت نشد ")
        );

        $backing = $this->opts->sole->rule("back.search")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($lists)->scope($backing);
    }

    public function list_gls($page)
    {
        $lists = $this->opts->query->type("list_gls")->table("group")
            ->cell("id", "title")->take(8)
            ->page($page)->chunk(2)
            ->prev("صفحه قبلی")->next("صفحه بعدی");

        $backing = $this->opts->sole->rule("back.group")->show("بازگشت");

        return $this->reply->node("panel.group")
            ->scope($lists)->scope($backing);
    }

    public function list_chg_gls()
    {
        ears()->set("group.id", lesa()->cals_data_obj->args->query);

        $items = $this->opts->pack->rule("delete")
            ->show("delete","حدف دسته بندی")
            ->args("delete", "query", lesa()->cals_data_obj->args->query)
            ->rule("edite")->show("edite", "ویرایش دسته بندی")
            ->rule("status")->show("status", "وضعیت دسته بندی")
            ->rule("parent")->show("parent", "تغییر والد دسته بندی");

        $backing = $this->opts->sole->rule("back.list")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($items)->scope($backing);
    }

    public function delete_gls()
    {
        $items = $this->opts->pack
            ->rule("back.list.chg")->show("back.list.chg", "انصراف")
            ->args("back.list.chg", "query", lesa()->cals_data_obj->args->query)
            ->rule("list.delete.confirm")->show("list.delete.confirm", "حذف کن")
            ->args("list.delete.confirm", "query", lesa()->cals_data_obj->args->query);

        return $this->reply->node("panel.group")->scope($items);
    }

    public function delete_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function status_gls($status)
    {
        $items = $this->opts->pack;

        if($status == true){
            $items->rule("list.status.disable")
            ->show("list.status.disable", "غیرفعال کن")
            ->args("list.status.disable", "type", "no");
        }else{
            $items->rule("list.status.enable")
            ->show("list.status.enable", "فعال کن")
            ->args("list.status.enable", "type", "yes");
        }

        $backing = $this->opts->sole->rule("back.list.chg")->show("بازگشت")
            ->args("query", ears()->get("group.id"));

        return $this->reply->node("panel.group")->scope($items)->scope($backing);
    }

    public function status_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.status")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function parent_gls()
    {
        $page = lesa()->cals_data_obj->args->page ?? 0;

        $empty = $this->opts->sole->rule("list.parent.empty")->show("والدی انتخاب نشود")
            ->args("query", null);

        $lists = $this->opts->query->type("list_parent_gls")->table("group")
            ->cell("id", "title")->take(8)->when("parent", null)
            ->page($page)->chunk(2);

        $backing = $this->opts->sole->rule("back.list.chg")->show("بازگشت")
            ->args("query", ears()->get("group.id"));

        return $this->reply->node("panel.group")->scope($empty)
            ->scope($lists)->scope($backing);
    }

    public function parent_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.chg")->show("بازگشت")
            ->args("query", ears()->get("group.id"));

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_gls()
    {
        $items = $this->opts->pack->rule("list.edite.name")
            ->show("list.edite.name", "عنوان انگلیسی")->rule("list.edite.title")
            ->show("list.edite.title", "عنوان فارسی")->rule("list.edite.desc")
            ->show("list.edite.desc", "توضیحات");

        $backing = $this->opts->sole->rule("back.list.chg")->show("بازگشت")
            ->args("query", ears()->get("group.id"));

        return $this->reply->node("panel.group")->scope($items)->scope($backing);
    }

    public function edite_name_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_name_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_title_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_title_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_desc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function edite_desc_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list.edit")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_gls()
    {
        $backing = $this->opts->sole->rule("back.group")->show("بازگشت");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_save_name_gls()
    {
        $backing = $this->opts->pack
            ->rule("back.group")->show("back.group", "انصراف")
            ->rule("confirm")->show("confirm", "مرحله بعدی");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_show_title_gls()
    {
        $backing = $this->opts->sole->rule("back.group")->show("انصراف");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_save_title_gls()
    {
        $backing = $this->opts->pack
            ->rule("back.group")->show("back.group", "انصراف")
            ->rule("confirm.two")->show("confirm.two", "مرحله بعدی");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_show_desc_gls()
    {
        $backing = $this->opts->sole->rule("back.group")->show("انصراف");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_save_desc_gls()
    {
        $backing = $this->opts->pack
            ->rule("back.group")->show("back.group", "انصراف")
            ->rule("confirm.three")->show("confirm.three", "مرحله بعدی");

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_parent_gls($page)
    {
        $parent_nls = $this->opts->sole->rule("empty")->show("والد خالی باشد")
            ->args("query", "nls");

        $lists = $this->opts->query->type("add.parent")->table("group")
            ->cell("id", "title")->take(8)
            ->page($page)->chunk(2)->enable();

        $backing = $this->opts->sole->rule("back.group")->show("انصراف");

        return $this->reply->node("panel.group")->scope($parent_nls)->scope($lists)->scope($backing);
    }

    public function add_status_gls()
    {
        $status = $this->opts->pack->rule("disable")->rule("enable")
            ->show("disable", "دسته بندی غیرفعال باشد")
            ->show("enable", "دسته بندی فعال باشد")
            ->args("disable", "query", "no")
            ->args("enable", "query", "yes");

        $backing = $this->opts->sole->rule("back.group")->show("انصراف");

        return $this->reply->node("panel.group")->scope($status)->scope($backing);
    }

    public function add_create_gls()
    {
        $backing = $this->opts->pack
            ->rule("confirm.for")->show("confirm.for", "ذخیره دسته بندی")
            ->rule("back.group")->show("back.group", "انصراف")
            ->chunk(1);

        return $this->reply->node("panel.group")->scope($backing);
    }

    public function add_create_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.group")->show("انصراف");

        return $this->reply->node("panel.group")->scope($backing);
    }
}