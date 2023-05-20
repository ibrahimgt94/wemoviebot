<?php

namespace lord\app;

use lord\dbs\group;
use lord\dbs\movie;
use lord\plg\telg\edge as telg_edge;
use lord\app\view\main as view_main;
use lord\app\reply\main as reply_main;
use lord\plg\telg\opts;

class main extends telg_edge
{
    private view_main $view_main;

    private reply_main $reply_main;

    public function __construct()
    {
        parent::__construct();

        $this->view_main = new view_main();

        $this->reply_main = new reply_main();

        $this->auto_register_new_user();
    }

    public function show(opts $opts): void
    {
        $text = $this->view_main->show();

        $reply = $this->reply_main->show();

        $opts->telg->send_mesg->chat_id()
            ->text($text)->markup($reply)->exec();
    }

    public function show2(opts $opts): void
    {
        $this->reset_point();

        $this->reset_type();

        ears()->reset();

        $text = $this->view_main->show();

        $reply = $this->reply_main->show();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function panel(opts $opts): void
    {
        $text = $this->view_main->panel();

        $reply = $this->reply_main->panel();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function groups(opts $opts, $args): void
    {
        ears()->set("ptype", "chaild");

        $text = $this->view_main->show();

        $reply = $this->reply_main->groups($args);

        $this->set_type("movie_gps");

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function movie_gps(opts $opts, $args): void
    {
        (! isset(lesa()->cals_data_obj->args->query)) ?: (
            ears()->set("group", lesa()->cals_data_obj->args->query)
        );

        $text = $this->view_main->show();

        $reply = $this->reply_main->movie_gps();

        $this->set_type("down_gps");

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function down_gps(opts $opts, $args): void
    {
        $this->reset_type();

        $text = json_encode(ears()->all());

        $reply = $this->reply_main->down_gps();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function help(opts $opts, $args): void
    {
        $text = $this->view_main->show();

        $reply = $this->reply_main->help();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function support(opts $opts, $args): void
    {
        $text = $this->view_main->show();

        $reply = $this->reply_main->support();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function search(opts $opts, $args): void
    {
        $this->set_point("search2");

        ears()->set("mesg.id", lesa()->mesg_id);

        $text = $this->view_main->show();

        $reply = $this->reply_main->search();

        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function data_search(opts $opts, $args): void
    {
        $this->reset_point();

        $text = lesa()->mesg_text;

        $reply = $this->reply_main->search();

        $mesg_id = ears()->get("mesg.id");

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function proposed(opts $opts, $args): void
    {
        ears()->set("group", 2);

        ears()->set("ptype", "parent");

        $this->movie_gps($opts, $args);
    }

    public function popular(opts $opts, $args): void
    {
        ears()->set("group", 3);

        ears()->set("ptype", "parent");

        $this->movie_gps($opts, $args);
    }
}