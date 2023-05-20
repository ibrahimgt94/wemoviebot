<?php

namespace lord\aps\panel\cog\orgs;

use lord\dbs\listx;
use lord\dbs\user;
use lord\plg\telg\eadg_reply;
use lord\plg\telg\reply as telg_reply;

class reply extends eadg_reply
{
    public function show_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("downs")->show("downs", "لینک ها")
            ->rule("subset")->show("subset", "زیرمجموعه")
            ->rule("support")->show("support", "پشتیبانی")
            ->rule("help")->show("help", "راهنما")
            ->rule("channel")->show("channel", "کانال")
            ->rule("status")->show("status", "وضعیت")
            ->rule("group")->show("group", "دسته بندی")
            ->rule("chunk")->show("chunk","صفحه بندی");

        $backing = $this->opts->sole->rule("back.panel")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($items)->node("panel")->scope($backing);
    }

    public function downs_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("down.uploadboy")
            ->show("down.uploadboy", "اپلودبوی")
            ->rule("down.ftp")
            ->show("down.ftp", "اف تی پی")
            ->rule("down.telegram")
            ->show("down.telegram", "تلگرام")->chunk(3);

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($items)->scope($backing);
    }

    public function down_uploadboy_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("uploadboy.password")
            ->show("uploadboy.password", "پسورد")
            ->rule("uploadboy.username")
            ->show("uploadboy.username", "یوزرنیم")
            ->rule("uploadboy.server")
            ->show("uploadboy.server", "سرور")
            ->chunk(3);

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($items)->scope($backing);
    }

    public function down_uploadboy_server_gls($args): telg_reply
    {
        $page = (lesa()->cals_data_obj->args->page ?? $args->page ?? 0);

        $items = $this->opts->list_ary->type("ups.boy.server")
            ->cell("ups.boy.server")->take(8)
            ->page($page)->chunk(2)->flag_on();

        $backing = $this->opts->sole->rule("back.down.uploadboy")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($items)->scope($backing);
    }

    public function down_uploadboy_username_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.uploadboy")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_uploadboy_username_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.uploadboy")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_uploadboy_password_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.uploadboy")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_uploadboy_password_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.uploadboy")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("ftp.password")
            ->show("ftp.password", "پسورد")
            ->rule("ftp.username")
            ->show("ftp.username", "یوزرنیم")
            ->rule("ftp.server")
            ->show("ftp.server", "سرور")
            ->chunk(3);

        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($items)->scope($backing);
    }

    public function down_ftp_server_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_server_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_username_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_username_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_password_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_ftp_password_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.down.ftp")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_telegram_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function down_telegram_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.downs")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function subset_gls(): telg_reply
    {
        $coin_cost = $this->opts->nums->rule("subset.coin.cost")
            ->caps("قیمت سکه")->start(100)->step(200)
            ->data_cell("subset.coin.cost")->end(900)
            ->after(" تومان")
            ->increase()->args_all("type", "cost");

        $coin = $this->opts->nums->rule("subset.coin")
            ->caps("سکه ها")->start(1)->step(1)
            ->data_cell("subset.coin")->end(9)->increase()
            ->args_all("type", "coin")->after(" سکه ");

        $items = $this->opts->status->rule("subset.status")
            ->cell("subset.status")->caps("وضعیت")
            ->disable("غیرفعال")->enable("فعال");

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($coin)->scope($items)->scope($coin_cost)->scope($backing);
    }

    public function support_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function support_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.support")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function help_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function help_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.help")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function channel_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("channel.p2")
            ->show("channel.p2", "کانال دوم")
            ->rule("channel.p1")
            ->show("channel.p1", "کانال اول")
            ->rule("channel.ps.show")
            ->show("channel.ps.show", "ویرایش وضعیت نمایش های کانال ها");

        $items_status_p1 = $this->opts->select
            ->rule("channel.status.p1")
            ->vals("enable", "disable")
            ->caps("وضعیت کانال اول")
            ->cell("channel.status.p1")
            ->show("enable", "نمایش داده نمی شود")
            ->show("disable", "قابل نمایش");

        $items_status_p2 = $this->opts->select
            ->rule("channel.status.p2")
            ->vals("enable", "disable")
            ->caps("وضعیت کانال دوم")
            ->cell("channel.status.p2")
            ->show("enable", "نمایش داده نمی شود")
            ->show("disable", "قابل نمایش");

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($items)
            ->scopes($items_status_p1, $items_status_p2)->scope($backing);
    }

    public function channel_after_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("chnl.after.addr")
            ->show("chnl.after.addr", "تغییر آدرس")
            ->rule("chnl.after.title")
            ->show("chnl.after.title", "تغییر عنوان");

        $backing = $this->opts->sole->rule("back.channel")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($items)->scope($backing);
    }

    public function channel_title_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.chnl.after")
            ->args("type", ears()->get("panel.channel.uniqid"))
            ->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function channel_title_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.chnl.after")
            ->args("type", ears()->get("panel.channel.uniqid"))
            ->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function channel_ps_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.chnl.after")
            ->args("type", ears()->get("panel.channel.uniqid"))
            ->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function channel_ps_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.chnl.after")
            ->args("type", ears()->get("panel.channel.uniqid"))
            ->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function chunk_gls(): telg_reply
    {
        $items = $this->opts->pack
            ->rule("chunk.rows")
            ->show("chunk.rows", "دکمه هر سطر")
            ->rule("chunk.take")
            ->show("chunk.take", "دکمه هر صفحه");

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($items)->scope($backing);
    }

    public function chunk_rows_gls(): telg_reply
    {
        $main_group = $this->opts->nums->rule("rows.main.group")
            ->caps("دسته بندی")
            ->start(1)->step(1)->end(3)
            ->data_cell("rows.main.gps")->increase()
            ->args_all("type", "rm_gps")->after(" count");

        $main_group_search = $this->opts->nums->rule("rows.main.group")
            ->caps("جستجو")
            ->start(1)->step(1)->end(3)
            ->data_cell("rows.main.gps.search")->increase()
            ->args_all("type", "rmg_search")->after(" count");

        $main_group_chaild = $this->opts->nums->rule("rows.main.group")
            ->caps("زیر مجموعه")
            ->start(1)->step(1)->end(3)
            ->data_cell("rows.main.gps.chaild")->increase()
            ->args_all("type", "rmg_chaild")->after(" count");

        $main_group_video = $this->opts->nums->rule("rows.main.group")
            ->caps("ویدئوها")
            ->start(1)->step(1)->end(3)
            ->data_cell("rows.main.gps.video")->increase()
            ->args_all("type", "rmg_video")->after(" count");

        $backing = $this->opts->sole->rule("back.cog.chunk")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($main_group_search)->scope($main_group)
            ->scope($main_group_chaild)->scope($main_group_video)->scope($backing);
    }

    public function chunk_take_gls(): telg_reply
    {
        $main_group = $this->opts->nums->rule("chunk.main.group")
            ->caps("دسته بندی")
            ->start(1)->step(1)->end(15)
            ->data_cell("chunk.main.gps")->increase()
            ->args_all("type", "cm_gps")->after(" count");

        $main_group_search = $this->opts->nums->rule("chunk.main.group")
            ->caps("جستجو")
            ->start(1)->step(1)->end(15)
            ->data_cell("chunk.main.gps.search")->increase()
            ->args_all("type", "cmg_search")->after(" count");

        $main_group_chaild = $this->opts->nums->rule("chunk.main.group")
            ->caps("زیر مجموعه")
            ->start(1)->step(1)->end(15)
            ->data_cell("chunk.main.gps.chaild")->increase()
            ->args_all("type", "cmg_chaild")->after(" count");

        $main_group_video = $this->opts->nums->rule("chunk.main.group")
            ->caps("ویدئوها")
            ->start(1)->step(1)->end(15)
            ->data_cell("chunk.main.gps.video")->increase()
            ->args_all("type", "cmg_video")->after(" count");

        $backing = $this->opts->sole->rule("back.cog.chunk")->show("بازگشت");

        return $this->reply->node("panel.cog")
            ->scope($main_group_search)->scope($main_group)
            ->scope($main_group_chaild)->scope($main_group_video)->scope($backing);
    }

    public function status_gls($status): telg_reply
    {
        $items = $this->opts->pack;

        if($status == true){
            $items->rule("status.disable")
                ->args("status.disable", "type", "no")
                ->show("status.disable", "غیرفعال کردن ربات");
        }else{
            $items->rule("status.enable")
                ->args("status.enable", "type", "yes")
                ->show("status.enable", "فعال کردن ربات");
        }

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($items)->scope($backing);
    }

    public function status_proc_gls(): telg_reply
    {
        $backing = $this->opts->sole->rule("back.status")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($backing);
    }

    public function group_gls($page): telg_reply
    {
        $items = $this->opts->list->type("group_gls")->table("group")
            ->cell("id", "title")->take(8)
            ->when("parent", null)
            ->page($page)->chunk(2)->selcs("gps");

        $backing = $this->opts->sole->rule("back.cog")->show("بازگشت");

        return $this->reply->node("panel.cog")->scope($items)->scope($backing);
    }
}