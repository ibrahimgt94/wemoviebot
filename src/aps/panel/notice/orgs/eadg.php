<?php

namespace lord\aps\panel\notice\orgs;

use Illuminate\Cache\Repository;
use Illuminate\Queue\Console\WorkCommand;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Queue;
use lord\cos\debug;
use lord\dbs\job;
use lord\dbs\listx;
use lord\dbs\movie;
use lord\dbs\notice;
use lord\dbs\user;
use lord\mig\jobs;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;

use App\Notifications\QueueHasLongWaitTime;
use lord\pro\lesa;


class eadg extends eage_clas
{
    public function show_gls(opts $opts, $args): void
    {
        $this->set_type("edit.notice");

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls($args)
        );
    }

    public function delete_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->delete_gls(),
            $opts->reply->delete_gls()
        );
    }

    public function delete_proc_gls(opts $opts): void
    {
        $status = notice::where("id", ears()->get("notice.id"))->delete();

        $this->base_edit_mesg($opts,
            $opts->view->delete_proc_gls($status),
            $opts->reply->delete_proc_gls()
        );
    }

    public function wait_after_gls(opts $opts): void
    {
        $this->set_type("wait.after.gls");

        $this->reset_point();

        ears()->reset();

        $this->base_edit_mesg($opts,
            $opts->view->wait_after_gls(),
            $opts->reply->wait_after_gls()
        );
    }

    public function wait_gls(opts $opts, $args): void
    {
        $this->set_type("wait.gls");

        $this->reset_point();

        $this->base_edit_mesg($opts,
            $opts->view->wait_gls(),
            $opts->reply->wait_gls($args)
        );
    }

    public function wait_search_gls(opts $opts): void
    {
        $this->reset_type();

        $this->set_point("wait.search.gls");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->wait_search_gls(),
            $opts->reply->wait_search_gls()
        );
    }

    public function wait_search_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("wait.gls");

        $notice_id = ears()->get("notice.id");

        $username = $this->valid()->rules(
            "regex:/^[a-z]{1}([\d\w]+)?$/", "min:5", "max:32"
        )->reply(
            "panel.notice", "back.notice.edit", [
                "query" => ears()->get("notice.id")
            ]
        )->runing();

        $finds_user = user::where("username", "like", "%{$username}%")->get();

        $finds = job::select("*");

        if($finds_user->isEmpty())
        {
            $job_finds = [];
        }else{
            $finds_user->pluck($finds_user, "id")->keys()->each(function ($user_id) use ($finds, $notice_id) {
                $finds->where("payload", "like", "%i:{$user_id};%")
                    ->where("payload", "like", "%i:{$notice_id};%");
            });

            $job_finds = $finds->pluck("id")->toArray();
        }

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->wait_search_gls())->markup(
                $opts->reply->wait_search_proc_gls($job_finds, $args)
            )->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function wait_show_gls(opts $opts): void
    {
        ears()->set("notice.wait.id", lesa()->cals_data_obj->args->query);

        $this->base_edit_mesg($opts,
            $opts->view->wait_show_gls(),
            $opts->reply->wait_show_gls()
        );
    }

    public function wait_resend_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->wait_resend_gls(),
            $opts->reply->wait_resend_gls()
        );
    }

    public function wait_resend_proc_gls(opts $opts): void
    {
        $status = false;

        $job_dbs = job::where("id", ears()->get("notice.wait.id"));

        if($job_dbs->exists()){
            $job_info = $job_dbs->first();

            $job_data = unserialize(json_decode($job_info->payload)->data->command);

            $payload_data = notice::get_payload_data($job_data, [
                "user_id", "notice_id"
            ]);

            \lord\job\notice::dispatchNow(
                ...$payload_data->toArray()
            );

            $job_dbs->delete();

            $status = true;
        }

        $this->base_edit_mesg($opts,
            $opts->view->wait_resend_proc_gls($status),
            $opts->reply->wait_resend_proc_gls()
        );
    }

    public function wait_delete_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->wait_delete_gls(),
            $opts->reply->wait_delete_gls()
        );
    }

    public function wait_delete_proc_gls(opts $opts): void
    {
        $status = job::where("id", ears()->get("notice.wait.id"))->delete();

        $this->base_edit_mesg($opts,
            $opts->view->wait_delete_proc_gls($status),
            $opts->reply->wait_delete_proc_gls()
        );
    }

    public function add_gls(opts $opts): void
    {
        $this->reset_type();

        $this->set_point("add.title.gls");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->add_gls(),
            $opts->reply->add_gls()
        );
    }

    public function add_title_gls(opts $opts): void
    {
        $this->set_point("add.body.gls");

        $title = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:30"
        )->reply(
            "panel.notice", "back.notice"
        )->runing();

        listx::puting("notice.add", ["title" => $title]);

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->add_title_gls())
            ->markup($opts->reply->add_title_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_body_gls(opts $opts): void
    {
        $this->reset_point();

        $body = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:255"
        )->reply(
            "panel.notice", "back.notice"
        )->runing();

        listx::puting("notice.add", ["body" => $body]);

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->add_body_gls())
            ->markup($opts->reply->add_body_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_status_gls(opts $opts): void
    {
        listx::puting("notice.add", [
            "status" => (lesa()->cals_data_obj->args->type == "on")
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->add_status_gls(),
            $opts->reply->add_status_gls()
        );
    }

    public function add_save_gls(opts $opts): void
    {
        $notice_add_data = listx::alling("notice.add");

        $status = notice::insert($notice_add_data);

        listx::where("name", "notice.add")->delete();

        $this->base_edit_mesg($opts,
            $opts->view->add_save_gls($status),
            $opts->reply->add_save_gls()
        );
    }

    public function edit_gls(opts $opts): void
    {
        $this->reset_point();

        $this->reset_type();

        $this->base_edit_mesg($opts,
            $opts->view->edit_gls(),
            $opts->reply->edit_gls()
        );
    }

    public function edit_title_gls(opts $opts): void
    {
        $this->set_point("edit.title.gls");

        $title = notice::where("id", ears()->get("notice.id"))->first()->title;

        $this->base_edit_mesg($opts,
            $opts->view->edit_title_gls($title),
            $opts->reply->edit_title_gls()
        );
    }

    public function edit_title_proc_gls(opts $opts): void
    {
        $this->reset_point();

        $title = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:30"
        )->reply(
            "panel.notice", "back.notice.edit.title"
        )->runing();

        $proc_status = notice::where(
            "id", ears()->get("notice.id")
        )->update(["title" => $title]);

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->edit_title_proc_gls($proc_status))
            ->markup($opts->reply->edit_title_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function edit_body_gls(opts $opts): void
    {
        $this->set_point("edit.body.gls");

        $body = notice::where("id", ears()->get("notice.id"))->first()->body;

        $this->base_edit_mesg($opts,
            $opts->view->edit_body_gls($body),
            $opts->reply->edit_body_gls()
        );
    }

    public function edit_body_proc_gls(opts $opts): void
    {
        $this->reset_point();

        $body = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:255"
        )->reply(
            "panel.notice", "back.notice.edit.title"
        )->runing();

        $proc_status = notice::where(
            "id", ears()->get("notice.id")
        )->update(["body" => $body]);

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->edit_body_proc_gls($proc_status))
            ->markup($opts->reply->edit_body_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function edit_status_gls(opts $opts): void
    {
        $status = notice::where("id", ears()->get("notice.id"))->first()->status;

        $this->base_edit_mesg($opts,
            $opts->view->edit_status_gls($status),
            $opts->reply->edit_status_gls($status)
        );
    }

    public function edit_status_proc_gls(opts $opts): void
    {
        $status = notice::where("id", ears()->get("notice.id"))->update([
            "status" => (lesa()->cals_data_obj->args->type == "on")
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->edit_status_proc_gls($status),
            $opts->reply->edit_status_proc_gls()
        );
    }
}