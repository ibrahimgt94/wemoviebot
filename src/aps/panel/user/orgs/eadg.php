<?php

namespace lord\aps\panel\user\orgs;

use lord\dbs\notice;
use lord\dbs\tmp;
use lord\dbs\user;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;
use lord\pro\ears;

class eadg extends eage_clas
{
    public function show_gls(opts $opts, $args): void
    {
        ears()->flush("user.id");

        $this->set_type("info_gls");

        $this->reset_point();

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls($args)
        );
    }

    public function search_gls(opts $opts): void
    {
        $this->reset_type();

        $this->base_edit_mesg($opts,
            $opts->view->search_gls(),
            $opts->reply->search_gls()
        );
    }

    public function search_id_gls(opts $opts): void
    {
        $this->set_point("user.search.id");

        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->search_id_gls(),
            $opts->reply->search_id_gls()
        );
    }

    public function search_id_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("info_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $find_id = $this->valid()->rules(
            "numeric", "min:7", "max:20"
        )->reply(
            "panel.user", "user.search.id"
        )->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_id_proc_gls())
            ->markup($opts->reply->search_id_proc_gls($find_id, $args))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function search_username_gls(opts $opts): void
    {
        $this->set_point("user.search.username");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->search_username_gls(),
            $opts->reply->search_username_gls()
        );
    }

    public function search_username_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("info_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $find_username = $this->valid()->rules(
            "regex:/^[a-z]{1}([\d\w]+)?$/", "min:5", "max:32"
        )->reply(
            "panel.user", "user.search.username"
        )->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_username_proc_gls())
            ->markup($opts->reply->search_username_proc_gls($find_username, $args))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function notice_all_gls(opts $opts, $args): void
    {
        $this->set_type("notice_all_gls");

        $this->base_edit_mesg($opts,
            $opts->view->notice_all_gls(),
            $opts->reply->notice_all_gls($args)
        );
    }

    public function notice_all_chg_gls(opts $opts): void
    {
        $notic = notice::where("id", lesa()->cals_data_obj->args->query)->first();

        $this->base_edit_mesg($opts,
            $opts->view->notice_all_chg_gls($notic),
            $opts->reply->notice_all_chg_gls($notic->id)
        );
    }

    public function notice_all_proc_gls(opts $opts): void
    {
        user::where("status", true)->get()->each(function ($user){
            \lord\job\notice::dispatch(
                $user->id, lesa()->cals_data_obj->args->notice
            )->delay(10);
        });

        $text = $opts->view->notice_proc_gls();

        $reply = $opts->reply->notice_all_proc_gls();

        $this->base_edit_mesg($opts, $text, $reply);
    }

    public function info_gls(opts $opts, $args): void
    {
        $this->reset_type();

        ears()->set_query("user.id");

        $user_info = user::select(
            "id", "username", "coin", "parent", "status", "subset"
        )->where("id", ears()->get("user.id"))->first();

        $this->base_edit_mesg($opts,
            $opts->view->info_gls($user_info),
            $opts->reply->info_gls($args)
        );
    }

    public function notice_gls(opts $opts, $args): void
    {
        $this->set_type("notice_gls");

        $this->base_edit_mesg($opts,
            $opts->view->notice_gls(),
            $opts->reply->notice_gls($args)
        );
    }

    public function notice_chg_gls(opts $opts): void
    {
        $notice_data = notice::where(
            "id", lesa()->cals_data_obj->args->query
        )->first();

        $this->base_edit_mesg($opts,
            $opts->view->notice_chg_gls($notice_data),
            $opts->reply->notice_chg_gls()
        );
    }

    public function notice_proc_gls(opts $opts): void
    {
        \lord\job\notice::dispatch(
            ears()->get("user.id"), lesa()->cals_data_obj->args->notice
        )->delay(10);

        $text = $opts->view->notice_proc_gls();

        $reply = $opts->reply->notice_proc_gls();

        $this->base_edit_mesg($opts, $text, $reply);
    }

    public function coin_gls(opts $opts): void
    {
        $coin_count = user::where("id", ears()->get("user.id"))->first()->coin;

        $this->base_edit_mesg($opts,
            $opts->view->coin_gls($coin_count),
            $opts->reply->coin_gls()
        );
    }

    public function coin_among_gls(opts $opts): void
    {
        $this->set_type("coin_among_gls");

        $self_user_coin = user::where(
            "id", ears()->get("user.id")
        )->first()->coin;

        $type = lesa()->cals_data_obj->args->type;

        $this->base_edit_mesg($opts,
            $opts->view->coin_among_gls($type),
            $opts->reply->coin_among_gls(
                lesa()->cals_data_obj->args->type,
                $self_user_coin
            )
        );
    }

    public function coin_proc_gls(opts $opts): void
    {
        $args = lesa()->cals_data_obj->args;

        $self_user = user::where("id", ears()->get("user.id"));

        ($args->type == "up") ? (
            $self_user->increment("coin", $args->digit)
        ): $self_user->decrement("coin", $args->digit);

        $text = $opts->view->coin_proc_gls($args->type, $args->digit);

        $reply = $opts->reply->coin_proc_gls();

        $this->base_edit_mesg($opts, $text, $reply);
    }

    public function status_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->status_gls(),
            $opts->reply->status_gls()
        );
    }

    public function status_proc_gls(opts $opts): void
    {
        $args_type = lesa()->cals_data_obj->args->type;

        $args_type_sta = ($args_type == "yes") ? true : false;

        user::where("id", ears()->get("user.id"))
            ->update(["status" => $args_type_sta]);

        $text = $args_type_sta ? (
            $opts->view->status_enable_gls()
        ) : $opts->view->status_disable_gls();

        $reply = $opts->reply->status_proc_gls();

        $this->base_edit_mesg($opts, $text, $reply);
    }
}