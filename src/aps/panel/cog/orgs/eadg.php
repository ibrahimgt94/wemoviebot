<?php

namespace lord\aps\panel\cog\orgs;

use lord\dbs\cog;
use lord\dbs\down;
use lord\dbs\listx;
use lord\dbs\tmp;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;

class eadg extends eage_clas
{
    public function show_gls(opts $opts): void
    {
        $this->reset_type();

        $this->reset_point();

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls()
        );
    }

    public function downs_gls(opts $opts): void
    {
        $this->reset_type();

        $this->base_edit_mesg($opts,
            $opts->view->downs_gls(),
            $opts->reply->downs_gls()
        );
    }

    public function down_uploadboy_gls(opts $opts): void
    {
        $this->reset_point();

        $info_down = unserialize(cog::where("name", "down.uploadboy")->first()->value);

        $info_down = collect($info_down)->object();

        $this->base_edit_mesg($opts,
            $opts->view->down_uploadboy_gls($info_down),
            $opts->reply->down_uploadboy_gls()
        );
    }

    public function down_uploadboy_server_gls(opts $opts, $args): void
    {
        $this->set_type("ups.boy.server");

        $query = lesa()->cals_data_obj->args->query ?? null;

        if(! is_null($query)){
            listx::puting("ups.boy.server", [$query], true);

            $down_ftp_dbs = cog::where("name", "down.uploadboy");

            if($down_ftp_dbs->exists()){
                $data = collect(unserialize($down_ftp_dbs->first()->value));

                $data->put("server", $query);

                $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
            }else{
                cog::insert(["name" => "down.uploadboy", "value" => serialize([
                    "server" => $query
                ])]);
            }
        }

        $this->base_edit_mesg($opts,
            $opts->view->down_uploadboy_server_gls(),
            $opts->reply->down_uploadboy_server_gls($args)
        );
    }

    public function down_uploadboy_username_gls(opts $opts): void
    {
        $this->reset_type();

        $this->set_point("ups.boy.server.username");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $user = collect(unserialize(
            cog::where("name", "down.uploadboy")->first()->value
        ))->get("username");

        $this->base_edit_mesg($opts,
            $opts->view->down_uploadboy_username_gls($user),
            $opts->reply->down_uploadboy_username_gls()
        );
    }

    public function down_uploadboy_username_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.cog", "uploadboy.username"
        )->runing();

        $down_ftp_dbs = cog::where("name", "down.uploadboy");

        if($down_ftp_dbs->exists()){
            $data = collect(unserialize($down_ftp_dbs->first()->value));

            $data->put("username", $channel_text);

            $status = $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
        }else{
            $status = cog::insert(["name" => "down.uploadboy", "value" => serialize([
                "username" => $channel_text
            ])]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_uploadboy_username_proc_gls($status))
            ->markup($opts->reply->down_uploadboy_username_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_uploadboy_password_gls(opts $opts): void
    {
        $this->set_point("ups.boy.server.password");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $pass = collect(unserialize(
            cog::where("name", "down.uploadboy")->first()->value
        ))->get("password");

        $this->base_edit_mesg($opts,
            $opts->view->down_uploadboy_password_gls($pass),
            $opts->reply->down_uploadboy_password_gls()
        );
    }

    public function down_uploadboy_password_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.cog", "uploadboy.password"
        )->runing();

        $down_ftp_dbs = cog::where("name", "down.uploadboy");

        if($down_ftp_dbs->exists()){
            $data = collect(unserialize($down_ftp_dbs->first()->value));

            $data->put("password", $channel_text);

            $status = $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
        }else{
            $status = cog::insert(["name" => "down.uploadboy", "value" => serialize([
                "password" => $channel_text
            ])]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_uploadboy_password_proc_gls($status))
            ->markup($opts->reply->down_uploadboy_password_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_ftp_gls(opts $opts): void
    {
        $this->reset_point();

        $info_down = unserialize(cog::where("name", "down.ftp")->first()->value);

        $info_down = collect($info_down)->object();

        $this->base_edit_mesg($opts,
            $opts->view->down_ftp_gls($info_down),
            $opts->reply->down_ftp_gls()
        );
    }

    public function down_ftp_server_gls(opts $opts): void
    {
        $this->set_point("down.ftp.server");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $server = collect(unserialize(
                cog::where("name", "down.ftp")->first()->value)
        )->get("server");

        $this->base_edit_mesg($opts,
            $opts->view->down_ftp_server_gls($server),
            $opts->reply->down_ftp_server_gls()
        );
    }

    public function down_ftp_server_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.cog", "ftp.server"
        )->runing();

        $down_ftp_dbs = cog::where("name", "down.ftp");

        if($down_ftp_dbs->exists()){
            $data = collect(unserialize($down_ftp_dbs->first()->value));

            $data->put("server", $channel_text);

            $status = $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
        }else{
            $status = cog::insert(["name" => "down.ftp", "value" => serialize([
                "server" => $channel_text
            ])]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_ftp_server_proc_gls($status))
            ->markup($opts->reply->down_ftp_server_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_ftp_username_gls(opts $opts): void
    {
        $this->set_point("down.ftp.username");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $user = collect(unserialize(
                cog::where("name", "down.ftp")->first()->value)
        )->get("username");

        $this->base_edit_mesg($opts,
            $opts->view->down_ftp_username_gls($user),
            $opts->reply->down_ftp_username_gls()
        );
    }

    public function down_ftp_username_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "alpha_num", "min:5", "max:20"
        )->reply(
            "panel.cog", "ftp.username"
        )->runing();

        $down_ftp_dbs = cog::where("name", "down.ftp");

        if($down_ftp_dbs->exists()){
            $data = collect(unserialize($down_ftp_dbs->first()->value));

            $data->put("username", $channel_text);

            $status = $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
        }else{
            $status = cog::insert(["name" => "down.ftp", "value" => serialize([
                "username" => $channel_text
            ])]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_ftp_username_proc_gls($status))
            ->markup($opts->reply->down_ftp_username_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_ftp_password_gls(opts $opts): void
    {
        $this->set_point("down.ftp.password");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $pass = collect(unserialize(
            cog::where("name", "down.ftp")->first()->value)
        )->get("password");

        $this->base_edit_mesg($opts,
            $opts->view->down_ftp_password_gls($pass),
            $opts->reply->down_ftp_password_gls()
        );
    }

    public function down_ftp_password_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "alpha_num", "min:5", "max:20"
        )->reply(
            "panel.cog", "ftp.password"
        )->runing();

        $down_ftp_dbs = cog::where("name", "down.ftp");

        if($down_ftp_dbs->exists()){
            $data = collect(unserialize($down_ftp_dbs->first()->value));

            $data->put("password", $channel_text);

            $status = $down_ftp_dbs->update(["value" => serialize($data->toArray())]);
        }else{
            $status = cog::insert(["name" => "down.ftp", "value" => serialize([
                "password" => $channel_text
            ])]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_ftp_password_proc_gls($status))
                ->markup($opts->reply->down_ftp_username_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_telegram_gls(opts $opts): void
    {
        $this->set_point("down.telg.cha");

        $this->set_clas_mesg();

        $info_chanel = cog::where("name", "down.telegram")->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->down_telegram_gls($info_chanel),
            $opts->reply->down_telegram_gls()
        );
    }

    public function down_telegram_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "regex:/^[a-z]{1}([\d\w]+)?$/", "min:5", "max:32"
        )->reply(
            "panel.cog", "down.telegram"
        )->runing();

        $down_telg_dbs = cog::where("name", "down.telegram");

        if($down_telg_dbs->exists()){
            $status = $down_telg_dbs->update(["value" => $channel_text]);
        }else{
            $status = cog::insert(["name" => "down.telegram", "value" => $channel_text]);
        }

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_telegram_proc_gls($status))
            ->markup($opts->reply->down_telegram_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function subset_gls(opts $opts): void
    {
        $args = lesa()->cals_data_obj->args;

        $this->cog_cell_ups_vals("subset.coin", "coin", $args);

        $this->cog_cell_ups_vals("subset.coin.cost", "cost", $args);

        $subset_status = cog::where("name", "subset.status");

        (! $subset_status->exists()) ?: (
            (! isset($args->status)) ?: (
                $subset_status->update(["value" => $args->status])
            )
        );

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->subset_gls()
        );
    }

    public function support_gls(opts $opts): void
    {
        $this->set_point("support.uniqid");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $support = cog::where("name", "support.uniqid")->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->support_gls($support),
            $opts->reply->support_gls()
        );
    }

    public function support_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $user_id = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:255"
        )->reply(
            "panel.cog", "support"
        )->runing();

        $cog_dbs = cog::where("name", "support.uniqid");

        $status = $cog_dbs->exists() ? (
            $cog_dbs->update(["value" => $user_id])
        ) : cog::insert(["name" => "support.uniqid", "value" => $user_id]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->support_proc_gls($status))
            ->markup($opts->reply->support_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function help_gls(opts $opts): void
    {
        $this->set_point("help.uniqid");

        $this->set_clas_mesg();

        $help = cog::where("name", "help.uniqid")->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->help_gls($help),
            $opts->reply->help_gls()
        );
    }

    public function help_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $user_id = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:255"
        )->reply(
            "panel.cog", "support"
        )->runing();

        $cog_dbs = cog::where("name", "help.uniqid");

        $status = $cog_dbs->exists() ? (
            $cog_dbs->update(["value" => $user_id])
        ) : cog::insert(["name" => "help.uniqid", "value" => $user_id]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->help_proc_gls($status))
            ->markup($opts->reply->help_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function channel_gls(opts $opts, $ears): void
    {
        $args_status = lesa()->cals_data_obj->args->status;

        if(isset($args_status, $ears->type)){
            if($ears->type == "p1"){
                cog::where("name", "channel.status.p1")->update([
                    "value" => $args_status
                ]);
            }

            if($ears->type == "p2"){
                cog::where("name", "channel.status.p2")->update([
                    "value" => $args_status
                ]);
            }

            $cog_dbs = cog::where("name", "channel.uniqid");

            $datas = collect(unserialize($cog_dbs->first()->value));

            $datas_two = collect($datas->get($ears->type))
                ->put("status", ($args_status == "enable"));

            $datas->put($ears->type, $datas_two->toArray());

            $status = $cog_dbs->update(["value" => serialize($datas->toArray())]);

        }

        $this->base_edit_mesg($opts,
            $opts->view->channel_gls(),
            $opts->reply->channel_gls()
        );
    }

    public function channel_after_gls(opts $opts, $ears): void
    {
        $this->reset_type();

        $this->reset_point();

        $type = $ears->type ?? lesa()->cals_data_obj->args->type;

        ears()->set("panel.channel.uniqid", $type);

        $channel_data = cog::where("name", "channel.uniqid")->first()->value;

        $channel_data = collect(collect(unserialize($channel_data))->get($type));

        $this->base_edit_mesg($opts,
            $opts->view->channel_after_gls($channel_data),
            $opts->reply->channel_after_gls()
        );
    }

    public function channel_title_gls(opts $opts, $ears): void
    {
        $this->set_point("channel.uniqid.title");

        $this->set_clas_mesg();

        $title = "ewf";

        $this->base_edit_mesg($opts,
            $opts->view->channel_title_gls($title),
            $opts->reply->channel_title_gls()
        );
    }

    public function channel_title_proc_gls(opts $opts): void
    {
        $this->reset_point();

        $channel_uniq = ears()->get("panel.channel.uniqid");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:20"
        )->reply(
            "panel.cog", "back.channel.title"
        )->runing();

        $cog_dbs = cog::where("name", "channel.uniqid");

        if(! $cog_dbs->exists()){
            cog::insert([
                "name" => "channel.uniqid", "value" => serialize([
                    "p1" => ["title" => "p1", "url" => "", "status" => true],
                    "p2" => ["title" => "p2", "url" => "", "status" => true],
                ])
            ]);
        }

        $datas = collect(unserialize($cog_dbs->first()->value));

        $datas_two = collect($datas->get($channel_uniq))->put("title", urlencode($channel_text));

        $datas->put($channel_uniq, $datas_two->toArray());

        $status = $cog_dbs->update(["value" => serialize($datas->toArray())]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->channel_title_proc_gls($status, (($channel_uniq == "p1") ? "اول" : "دوم")))
            ->markup($opts->reply->channel_title_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();

    }

    public function channel_ps_gls(opts $opts,  $ears): void
    {
        $this->set_point("channel.uniqid");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->channel_ps_gls(),
            $opts->reply->channel_ps_gls()
        );
    }

    public function channel_ps_proc_gls(opts $opts): void
    {
        $this->reset_point();

        $channel_uniq = ears()->get("panel.channel.uniqid");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $channel_text = $this->valid()->rules(
            "url", "min:5", "max:150"
        )->reply(
            "panel.cog", "back.channel.ps"
        )->runing();

        $cog_dbs = cog::where("name", "channel.uniqid");

        $datas = collect(unserialize($cog_dbs->first()->value));

        $datas_two = collect($datas->get($channel_uniq))->put("url", $channel_text);

        $datas->put($channel_uniq, $datas_two->toArray());

        $status = $cog_dbs->update(["value" => serialize($datas->toArray())]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->channel_ps_proc_gls($status, (($channel_uniq == "p1") ? "اول" : "دوم")))
            ->markup($opts->reply->channel_ps_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    private function cog_cell_ups_vals($name, $type, $args)
    {
        $hand = cog::where("name", $name);

        (! $hand->exists()) ?: (
            (! isset($args->nums, $args->type) ?:
                (($args->type == $type) ? $hand->update(["value" => $args->nums]) : null)
            )
        );
    }

    public function chunk_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->chunk_gls(),
            $opts->reply->chunk_gls()
        );
    }

    public function chunk_rows_gls(opts $opts): void
    {
        $args = lesa()->cals_data_obj->args;

        $this->cog_cell_ups_vals("rows.main.gps", "rm_gps", $args);

        $this->cog_cell_ups_vals("rows.main.gps.search", "rmg_search", $args);

        $this->cog_cell_ups_vals("rows.main.gps.chaild", "rmg_chaild", $args);

        $this->cog_cell_ups_vals("rows.main.gps.video", "rmg_video", $args);

        $this->base_edit_mesg($opts,
            $opts->view->chunk_rows_gls(),
            $opts->reply->chunk_rows_gls()
        );
    }

    public function chunk_take_gls(opts $opts): void
    {
        $args = lesa()->cals_data_obj->args;

        $this->cog_cell_ups_vals("chunk.main.gps", "cm_gps", $args);

        $this->cog_cell_ups_vals("chunk.main.gps.search", "cmg_search", $args);

        $this->cog_cell_ups_vals("chunk.main.gps.chaild", "cmg_chaild", $args);

        $this->cog_cell_ups_vals("chunk.main.gps.video", "cmg_video", $args);

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->chunk_take_gls()
        );
    }

    public function status_gls(opts $opts): void
    {
        $cog_dbs = cog::where("name", "status");

        if(! $cog_dbs->exists()){
            cog::insert([
                "name" => "status",
                "value" => false
            ]);
        }

        $status = $cog_dbs->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->status_gls($status),
            $opts->reply->status_gls($status)
        );
    }

    public function status_proc_gls(opts $opts): void
    {
        $status = cog::where("name", "status")->update([
            "value" => lesa()->cals_data_obj->args->type == "yes" ? true : false
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->status_proc_gls($status),
            $opts->reply->status_proc_gls()
        );
    }

    public function group_gls(opts $opts): void
    {
        $page = lesa()->cals_data_obj->args->page ?? 0;

        $this->set_type("group_gls");

        $this->auto_list("gps");

        $this->base_edit_mesg($opts,
            $opts->view->group_gls(),
            $opts->reply->group_gls($page)
        );
    }
}