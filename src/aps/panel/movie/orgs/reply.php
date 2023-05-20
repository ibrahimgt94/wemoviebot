<?php

namespace lord\aps\panel\movie\orgs;

use lord\dbs\listx;
use lord\dbs\movie;
use lord\dbs\user;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\reply as telg_reply;
use lord\pro\ears;

class reply extends eadg_reply
{
    public function show_gls(): telg_reply
    {
        $search = $this->opts->sole->rule("search")->show("جستجوی فیلم");

        $items = $this->opts->pack->rule("add")
            ->show("add", "افزودن فیلم")->rule("list")
            ->show("list", "لیست فیلم ها");

        $backing = $this->opts->sole->rule("back.panel")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($search)
            ->scope($items)->node("panel")->scope($backing);
    }

    public function search_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function search_proc_gls($search, $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->query->type("list_gls")
            ->table("movie")->when("title", "like", "%{$search}%")
            ->cell("id", "title")->take(8)->page($page)
            ->chunk(1);

        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function list_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->query->type("list_gls")->table("movie")
            ->cell("id", "title")->take(8)->page($page)
            ->when("is_draft", false)->chunk(1);

        if(empty($items->get_tmps())){
            $items = $this->opts->sole->rule("is.not.working")
                ->show("فیلمی پیدا نشد");
        }

        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function list_show_gls($is_draft): telg_reply
    {
        ears()->set("movie.draft.list", true);

        $items = $this->opts->pack
            ->rule("image")->show("image", "تصاویر")
            ->rule("title")->show("title", "عنوان")
            ->rule("summary")->show("summary", "خلاصه")
            ->rule("property")->show("property", "خصوصیات")
            ->rule("status")->show("status", "وضعیت")
            ->rule("down")->show("down", "لینک ها");

        if($is_draft){
            $items->rule("add.draft.save")
                ->show("add.draft.save", "ذخیره پیش نویس");

            ears()->set("backing.movie", "back.add.draft.show");

            $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");
        }else{
            ears()->set("backing.movie", "back.list");

            
            $items->rule("sendchannel")->show("sendchannel", "ارسال به کانال");
            $items->rule("sendsite")->show("sendsite", "ارسال به سایت");
            $items->rule("dels")->show("dels", "حذف این فیلم");

            $backing = $this->opts->sole->rule("back.list")->show("بازگشت");
        }

        return $this->reply->node("panel.movie")
           ->scope($items)->scope($backing);
    }

    public function sendsite_gls()
    {
        $backing = $this->opts->sole->rule("back.list")->show("بازگشت");
        
        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function sendchannel_gls()
    {
        $backing = $this->opts->sole->rule("back.list")->show("بازگشت");
        
        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function dels_gls()
    {
        $items = $this->opts->pack->rule("back.list.show")
            ->show("back.list.show", "انصراف")
            ->args("back.list.show", "query", ears()->get("movie.id"))
            ->rule("confirm.dels")
            ->show("confirm.dels", "حذف کن");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function dels_proc_gls()
    {
        $backing = $this->opts->sole->rule("back.list")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    private function back_list_show()
    {
        $backing = $this->back_list_show_two();

        return $this->reply->node("panel.movie")->scope($backing);
    }

    private function back_list_show_two()
    {
        $draft_has = ears()->get("movie.draft.has");

        $draft_list = ears()->get("movie.draft.list");

        if(($draft_has == true) and ($draft_list == false)){
            $backing = $this->opts->sole->rule(ears()->get("backing.movie"))
                ->args("query", ears()->get("movie.id"))->show("بازگشت");
        }else{
            $backing = $this->opts->sole->rule("back.list.show")
                ->show("انصراف")
                ->args("query", ears()->get("movie.id"));
        }

        return $backing;
    }

    public function image_gls($image): telg_reply
    {
        $backing = $this->back_list_show_two();

        $reply = $this->reply->node("panel.movie");

        if(! empty($image)){
            $reply->addrs($this->opts->addrs->url($image)
                ->show("تصویر فعلی"));
        }

        return $reply->scope($backing);
    }

    public function image_proc_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function title_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function title_proc_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function summary_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function summary_proc_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function status_gls($status): telg_reply
    {
        $items = $this->opts->pack;

        if($status){
            $items->rule("disable")
                ->show("disable", "غیرفعال کن")
                ->args("disable", "type", "off");
        }else{
            $items->rule("enable")->show("enable", "فعال کن")
                ->args("enable", "type", "on");
        }

        $backing = $this->back_list_show_two();

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function status_proc_gls(): telg_reply
    {
        return $this->back_list_show();
    }

    public function group_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("group_gls")
            ->selcs("movie.gps")->table("group")
            ->cell("id", "title")->take(8)
            ->page($page)->chunk(2);

        $backing = $this->back_list_show_two();

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function down_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $add_down = $this->opts->pack
            ->rule("edit.down.add")
            ->show("edit.down.add","افزودن لینک دانلود");

        $items = $this->opts->fetch->type("down_gls")
            ->datas(function (){
                return movie::where("id", ears()->get("movie.id"))
                    ->first()->downs();
            })->cell("id", "title")->take(8)->page($page)->chunk(2);

        $backing = $this->back_list_show_two();

        return $this->reply->node("panel.movie")
            ->scope($add_down)->scope($items)->scope($backing);
    }

    public function down_auto_add_addr_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_auto_add_addr_two_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("back.downs")
            ->show("back.downs","بازگشت")
            ->rule("auto.add.down.confirm")
            ->show("auto.add.down.confirm", "مرحله بعدی");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function down_auto_add_addr_three_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list_ary->type("down_auto_add_addr")
            ->cell("down.title")->page($page)
            ->take(4)->chunk(1)->hide_page();

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function down_add_addr_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $downs = movie::where("id", ears()->get("movie.id"))->first()->downs()->get();

        $down_list = $downs->pluck("type")->map(function ($key){
            return ($key == 0) ? "ups2" : "ups1";
        })->values()->toArray();

        $items = $this->opts->list_ary->type("down_add_addr_gls")
            ->cell("down.title")->page($page)->not_when($down_list)
            ->take(4)->chunk(1)->hide_page();

        if(empty($items->get_tmps())){
            $items = $this->opts->sole->rule("is.not.work")
                ->show("چیزی یافت نشد");
        }

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function down_add_addr_two_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_add_addr_three_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("back.downs")
            ->show("back.downs", "انصراف")
            ->rule("dowm.add.addr.confirm")
            ->show("dowm.add.addr.confirm", "مرحله بعدی");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function down_add_addr_for_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("down.add.addr.disable")
            ->show("down.add.addr.disable", "غیرفعال")
            ->args("down.add.addr.disable","type", 0)
            ->rule("down.add.addr.enable")
            ->show("down.add.addr.enable", "فعال")
            ->args("down.add.addr.enable", "type", 1);

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function down_add_addr_fiv_gls($is_direct): telg_reply
    {
        $items = $this->opts->pack
            ->rule("dowm.add.addr.confirm.two")
            ->show("dowm.add.addr.confirm.two", "تایید و ساخت لینک");

        if(! is_null($is_direct) and $is_direct)
        {
            $items->rule("dowm.add.addr.confirm.two.auto")
                ->show("dowm.add.addr.confirm.two.auto", "تایید و اپلود لینک");
        }

        $items->rule("back.downs")
            ->show("back.downs", "انصراف")
            ->chunk(1);

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function down_add_addr_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_add_addr_auto_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_show_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("edit.title")
            ->show("edit.title", "ویرایش عنوان لینک")
            ->rule("edit.addrs")
            ->show("edit.addrs", "ویرایش آدرس لینک")
            ->rule("delete.addrs")
            ->show("delete.addrs", "حذف لینک دانلود")
            ->rule("status.addrs")
            ->show("status.addrs", "وضعیت لینک دانلود");

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function down_delete_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("back.downs.show")
            ->show("back.downs.show", "انصراف")
            ->args("back.downs.show", "query", ears()->get("movie.down.id"))
            ->rule("confirm.delete")
            ->show("confirm.delete", "حذف کن");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function down_delete_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_edit_title_gls($is_direct, $args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $list = ($is_direct == true) ? "ups1" : "ups2";

        $items = $this->opts->list_ary->type("down_edit_title_gls")
            ->cell("down.title")->page($page)->not_when([$list])
            ->take(4)->chunk(1)->hide_page();

        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function down_edit_title_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show.title")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_edit_addrs_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_edit_addrs_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function down_edit_status_gls($status): telg_reply
    {
        $items = $this->opts->pack;

        if($status == 1){
            $items->rule("status.addrs.disable")
                ->show("status.addrs.disable", "غیرفعال کن")
                ->args("status.addrs.disable", "type", "off");
        }else{
           $items->rule("status.addrs.enable")
               ->show("status.addrs.enable", "فعال کن")
               ->args("status.addrs.enable", "type", "on");
        }

        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function down_edit_status_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show.status")
            ->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function property_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("property.director")
            ->show("property.director", "کارگردان")
            ->rule("property.producer")->show("property.producer", "تهیه کننده")
            ->rule("property.writer")->show("property.writer", "نویسنده")
            ->rule("property.year")->show("property.year", "سال ساخت")
            ->rule("property.filming")->show("property.filming", "مدیر فیلم برداری")
            ->rule("property.singer")->show("property.singer", "خواننده ها")
            ->rule("property.actors")->show("property.actors", "بازیگران")
            ->rule("property.duration")->show("property.duration", "مدت زمان فیلم")
            ->rule("property.asong")->show("property.asong", "آهنگساز");

        $backing = $this->back_list_show_two();

        return $this->reply->node("panel.movie")
            ->scope($items)->scope($backing);
    }

    public function director_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("director_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 3)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("director", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function producer_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("producer_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 7)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("producer", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function writer_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("writer_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 6)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("writer", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function year_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("year_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 5)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("year", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function filming_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("filming_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 9)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("filming", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function singer_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("singer_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 8)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("singer", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function actors_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("actors_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 4)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("actors", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function duration_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("duration_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 10)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("duration", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function asong_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list->type("asong_gls")
            ->table("group")->cell("id", "title")
            ->when("parent", 11)
            ->take(8)->page($page)->chunk(2)
            ->opts_two("movie.id", "movie_id")
            ->selcs("asong", "propertys");

        $backing = $this->opts->sole->rule("back.list.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_show_gls($is_draft): telg_reply
    {
        $items = $this->opts->pack;

        ears()->set("movie.draft.list", false);

        if($is_draft){
            $items->rule("add.mory.draft")
                ->show("add.mory.draft", "ادامه پیش نویس فعلی")
                ->rule("add.del.draft")
                ->show("add.del.draft", "حذف و ایجاد پیش نویس جدید");
        }else{
            $items->rule("add.del.draft")
                ->show("add.del.draft", "ایجاد پیش نویس");
        }

        $items->chunk(1);

        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    private function add_draft_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("add.draft.image")
            ->show("add.draft.image", "تصاویر")
            ->rule("add.draft.title")
            ->show("add.draft.title", "عنوان")
            ->rule("add.draft.summary")
            ->show("add.draft.summary", "خلاصه")
            ->rule("add.draft.property")
            ->show("add.draft.property", "خصوصیات")
            ->rule("add.draft.status")
            ->show("add.draft.status", "وضعیت")
            ->rule("add.draft.down")
            ->show("add.draft.down", "لینک ها")
            ->rule("add.draft.save")
            ->show("add.draft.save", "ذخیره");

        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_save_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_save_err_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule(ears()->get("backing.movie"))
            ->args("query", ears()->get("movie.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_mory_draft_gls(): telg_reply
    {
        return $this->add_draft_gls();
    }

    public function add_del_draft_gls(): telg_reply
    {
        return $this->add_draft_gls();
    }
}