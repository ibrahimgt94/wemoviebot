<?php

namespace lord\app;

use lord\dbs\group;
use lord\dbs\movie;
use lord\plg\telg\edge as telg_edge;
use lord\app\view\panel as view_panel;
use lord\app\reply\panel as reply_panel;
use lord\plg\telg\opts;

class panel extends telg_edge
{
    private view_panel $view_main;

    private reply_panel $reply_main;

    public function __construct()
    {
        parent::__construct();

        $this->view_panel = new view_panel();

        $this->reply_panel = new reply_panel();
    }

    public function user(opts $opts): void
    {
        $this->set_type("info_user");

        $text = $this->view_panel->show();

        $reply = $this->reply_panel->users();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user(opts $opts): void
    {
        $this->reset_type();

        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user_coin(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user_coin();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user_coin_chg(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user_coin_chg();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user_coin_proc(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user_coin_proc();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user_status(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user_status();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function info_user_status_proc(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->info_user_status_proc();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function movie(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->users();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function cogs(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->users();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function group(opts $opts): void
    {
        $text = $this->view_panel->show();

        $reply = $this->reply_panel->users();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }
}