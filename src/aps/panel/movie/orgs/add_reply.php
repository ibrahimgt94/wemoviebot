<?php

namespace lord\aps\panel\movie\orgs;

use lord\dbs\data;
use lord\dbs\down;
use lord\dbs\listx;
use lord\dbs\movie;
use lord\dbs\tmp;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\opts;
use lord\plg\telg\reply as telg_reply;

trait add_reply
{
    public function add_show_gls($is_draft): telg_reply
    {
        $items = $this->opts->pack;

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
        $backing = $this->opts->sole->rule("back.show")->show("بازگشت");

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

    public function add_draft_title_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_title_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_image_gls($image): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        $reply =  $this->reply->node("panel.movie");

        if(! empty($image)){
            $reply->addrs($this->opts->addrs->url($image)
                ->show("تصویر فعلی"));
        }

        return $reply->scope($backing);
    }

    public function add_draft_image_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_summary_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_summary_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_status_gls($status): telg_reply
    {
        $items = $this->opts->pack;

        if($status){
            $items->rule("add.draft.status.disable")
                ->show("add.draft.status.disable", "غیرفعال کن")
                ->args("add.draft.status.disable", "type", "off");
        }else{
            $items->rule("add.draft.status.enable")
                ->show("add.draft.status.enable", "فعال کن")
                ->args("add.draft.status.enable", "type", "on");
        }

        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_status_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_property_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("add.draft.property.director")
            ->show("add.draft.property.director", "کارگردان")
            ->rule("add.draft.property.producer")
            ->show("add.draft.property.producer", "تهیه کننده")
            ->rule("add.draft.property.writer")
            ->show("add.draft.property.writer", "نویسنده")
            ->rule("add.draft.property.year")
            ->show("add.draft.property.year", "سال ساخت")
            ->rule("add.draft.property.filming")
            ->show("add.draft.property.filming", "مدیر فیلم برداری")
            ->rule("add.draft.property.singer")
            ->show("add.draft.property.singer", "خواننده ها")
            ->rule("add.draft.property.actors")
            ->show("add.draft.property.actors", "بازیگران")
            ->rule("add.draft.property.duration")
            ->show("add.draft.property.duration", "مدت زمان فیلم")
            ->rule("add.draft.property.asong")
            ->show("add.draft.property.asong", "آهنگساز");

        $backing = $this->opts->sole->rule("back.add.draft")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_director_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_director_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 3)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("director", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_producer_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_producer_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 7)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("producer", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_writer_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_writer_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 6)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("writer", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_year_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_year_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 5)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("year", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_filming_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_filming_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 9)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("filming", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_singer_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_singer_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 8)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("singer", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_actors_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_actors_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 4)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("actors", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_duration_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_duration_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 10)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("duration", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_asong_gls(): telg_reply
    {
        $items = $this->opts->list->type("add_draft_asong_gls")
            ->table("groups")->cell("id", "title")
            ->when("parent", 11)
            ->take(8)->page(0)->chunk(2)
            ->opts_two("movie.draft.id", "movie_id")
            ->selcs("asong", "propertys");

        $backing = $this->opts->sole->rule("back.add.draft.property")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_down_gls(): telg_reply
    {
        $add_down = $this->opts->pack
            ->rule("add.draft.edit.down.add")
            ->show("add.draft.edit.down.add","افزودن لینک دانلود");

        $items = $this->opts->fetch->type("add_draft_down_gls")
            ->datas(function (){
                return movie::where("id", ears()->get("movie.draft.id"))
                    ->first()->downs();
            })->cell("id", "title")->take(8)->page(0)->chunk(2);

        $backing = $this->opts->sole->rule("back.list.show")->show("بازگشت")
            ->args("query", ears()->get("movie.draft.id"));

        return $this->reply->node("panel.movie")
            ->scope($add_down)->scope($items)->scope($backing);
    }

    public function add_draft_down_auto_add_addr_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_auto_add_addr_two_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("back.downs")
            ->show("back.downs","بازگشت")
            ->rule("auto.add.down.confirm")
            ->show("auto.add.down.confirm", "مرحله بعدی");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function add_draft_down_auto_add_addr_three_gls(): telg_reply
    {
        $items = $this->opts->list_ary->type("down_auto_add_addr")
            ->cell("down.title")->page(0)
            ->take(4)->chunk(1)->hide_page();

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_down_add_addr_gls(): telg_reply
    {
        $downs = movie::where("id", ears()->get("movie.id"))->first()->downs()->get();

        $down_list = $downs->pluck("type")->map(function ($key){
            return ($key == 0) ? "ups2" : "ups1";
        })->values()->toArray();

        $items = $this->opts->list_ary->type("down_add_addr_gls")
            ->cell("down.title")->page(0)->not_when($down_list)
            ->take(4)->chunk(1)->hide_page();

        if(empty($items->get_tmps())){
            $items = $this->opts->sole->rule("is.not.work")
                ->show("چیزی یافت نشد");
        }

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_down_add_addr_two_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_add_addr_three_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("back.downs")
            ->show("back.downs", "انصراف")
            ->rule("dowm.add.addr.confirm")
            ->show("dowm.add.addr.confirm", "مرحله بعدی");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function add_draft_down_add_addr_for_gls(): telg_reply
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

    public function add_draft_down_add_addr_fiv_gls($is_direct): telg_reply
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

    public function add_draft_down_add_addr_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_add_addr_auto_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_show_gls(): telg_reply
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

    public function add_draft_down_delete_gls(): telg_reply
    {
        $items = $this->opts->pack->rule("back.downs.show")
            ->show("back.downs.show", "انصراف")
            ->args("back.downs.show", "query", ears()->get("movie.down.id"))
            ->rule("confirm.delete")
            ->show("confirm.delete", "حذف کن");

        return $this->reply->node("panel.movie")->scope($items);
    }

    public function add_draft_down_delete_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_edit_title_gls($is_direct): telg_reply
    {
        $list = ($is_direct == true) ? "ups1" : "ups2";

        $items = $this->opts->list_ary->type("down_edit_title_gls")
            ->cell("down.title")->page(0)->not_when([$list])
            ->take(4)->chunk(1)->hide_page();

        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($items)->scope($backing);
    }

    public function add_draft_down_edit_title_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show.title")->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_edit_addrs_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_edit_addrs_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show")
            ->args("query", ears()->get("movie.down.id"))->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }

    public function add_draft_down_edit_status_gls($status): telg_reply
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

    public function add_draft_down_edit_status_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs.show.status")
            ->show("بازگشت");

        return $this->reply->node("panel.movie")->scope($backing);
    }
}