<?php

namespace lord\aps\panel\group\orgs;

use lord\dbs\group;
use lord\dbs\tmp;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;

class eadg extends eage_clas
{
    public function show_gls(opts $opts): void
    {
        $this->reset_point();

        $this->reset_type();

        ears()->flush("gps.add");

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls()
        );
    }

    public function search_gls(opts $opts): void
    {
        $this->reset_point();

        $this->reset_type();
        
        $this->base_edit_mesg($opts,
            $opts->view->search_gls(),
            $opts->reply->search_gls()
        );
    }

    public function search_by_name_gls(opts $opts): void
    {
        $this->set_point("list.search.by.name.gls");

        $this->base_edit_mesg($opts,
            $opts->view->search_by_name_gls(),
            $opts->reply->search_by_name_gls()
        );
    }

    public function search_by_title_gls(opts $opts): void
    {
        $this->set_point("list.search.by.title.gls");

        $this->base_edit_mesg($opts,
            $opts->view->search_by_title_gls(),
            $opts->reply->search_by_title_gls()
        );
    }

    public function search_by_name_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("list_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $search_text = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.group", "search.by.name"
        )->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_by_name_proc_gls())
            ->markup($opts->reply->search_by_name_proc_gls($search_text, $args))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function search_by_title_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("list_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $search_text = $this->valid()->rules(
            "persian_alpha", "min:5", "max:20"
        )->reply(
            "panel.group", "search.by.title"
        )->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_by_title_proc_gls())
            ->markup($opts->reply->search_by_title_proc_gls($search_text, $args))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function list_gls(opts $opts): void
    {
        $this->set_type("list_gls");

        ears()->reset();

        $page = lesa()->cals_data_obj->args->page ?? 0;

        $this->base_edit_mesg($opts,
            $opts->view->list_gls(),
            $opts->reply->list_gls($page)
        );
    }

    public function list_chg_gls(opts $opts)
    {
        $group = group::where("id", lesa()->cals_data_obj->args->query)->first();

        ears()->set("gps.list.chg", $group->id);

        ears()->set("gps.list.chg.parent", $group->parent ?? "nls");

        $group->parent_title = empty($group->parent) ? "والدی انتخاب نشده" : (
            group::where("id", $group->parent)->first()->title
        );

        $this->base_edit_mesg($opts,
            $opts->view->list_chg_gls($group),
            $opts->reply->list_chg_gls()
        );
    }

    public function delete_gls(opts $opts)
    {
        $this->base_edit_mesg($opts,
            $opts->view->delete_gls(),
            $opts->reply->delete_gls()
        );
    }

    public function delete_proc_gls(opts $opts)
    {
        $group = group::where("id", lesa()->cals_data_obj->args->query);

        $status = (! $group->exists()) ? false : $group->delete();

        $this->base_edit_mesg($opts,
            $opts->view->delete_proc_gls($status),
            $opts->reply->delete_proc_gls()
        );
    }

    public function status_gls(opts $opts)
    {
        $gps_dbs = group::where("id", ears()->get("group.id"))->first();

        $this->base_edit_mesg($opts,
            $opts->view->status_gls($gps_dbs->title, $gps_dbs->status),
            $opts->reply->status_gls($gps_dbs->status)
        );
    }

    public function status_proc_gls(opts $opts)
    {
        $gps_id = ears()->get("gps.list.chg");

        $args_type = lesa()->cals_data_obj->args->type;

        $gps_dbs = group::where("id", ears()->get("group.id"));

        $status = $gps_dbs->update([
            "status" => ($args_type == "yes")
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->status_proc_gls($status, $args_type),
            $opts->reply->status_proc_gls()
        );
    }

    public function parent_gls(opts $opts)
    {
        $this->set_type("list_parent_gls");

        $gps_parent = ears()->get("gps.list.chg.parent");

        $gps_title = ($gps_parent == "nls") ? "والدی انتخاب نشده" : (
            group::where("id", $gps_parent)->first()->title
        );

        $this->base_edit_mesg($opts,
            $opts->view->parent_gls($gps_title),
            $opts->reply->parent_gls()
        );
    }

    public function parent_proc_gls(opts $opts)
    {
        $status = group::where("id", ears()->get("group.id"))->update([
            "parent" => lesa()->cals_data_obj->args->query
        ]);

        $this->base_edit_mesg($opts,
            $opts->view->parent_proc_gls($status),
            $opts->reply->parent_proc_gls()
        );
    }

    public function edite_gls(opts $opts)
    {
        $this->reset_type();

        $this->base_edit_mesg($opts,
            $opts->view->edite_gls(),
            $opts->reply->edite_gls()
        );
    }

    public function edite_name_gls(opts $opts)
    {
        $this->set_point("edite.name.gls");

        $this->set_clas_mesg();

        $group = group::where("id", ears()->get("group.id"))->first();

        $this->base_edit_mesg($opts,
            $opts->view->edite_name_gls($group->name),
            $opts->reply->edite_name_gls()
        );
    }

    public function edite_name_proc_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $name = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.group", "list.edite.name"
        )->runing();

        $status = group::where("id", ears()->get("group.id"))
            ->update(["name" => $name]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->edite_name_proc_gls($status))
            ->markup($opts->reply->edite_name_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function edite_title_gls(opts $opts)
    {
        $this->set_point("edite.title.gls");

        $this->set_clas_mesg();

        $group = group::where("id", ears()->get("group.id"))->first();

        $this->base_edit_mesg($opts,
            $opts->view->edite_title_gls($group->title),
            $opts->reply->edite_title_gls()
        );
    }

    public function edite_title_proc_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $name = $this->valid()->rules(
            "persian_alpha", "min:5", "max:20"
        )->reply(
            "panel.group", "list.edite.title"
        )->runing();

        $status = group::where("id", ears()->get("group.id"))
            ->update(["title" => $name]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->edite_title_proc_gls($status))
            ->markup($opts->reply->edite_title_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function edite_desc_gls(opts $opts)
    {
        $this->set_point("edite.desc.gls");

        $this->set_clas_mesg();

        $group = group::where("id", ears()->get("group.id"))->first();

        $this->base_edit_mesg($opts,
            $opts->view->edite_desc_gls($group->desc),
            $opts->reply->edite_desc_gls()
        );
    }

    public function edite_desc_proc_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $desc = $this->valid()->rules(
            "persian_alpha", "min:5", "max:255"
        )->reply(
            "panel.group", "list.edite.desc"
        )->runing();

        $status = group::where("id", ears()->get("group.id"))->update(["desc" => $desc]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->edite_desc_proc_gls($status))
            ->markup($opts->reply->edite_desc_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_gls(opts $opts): void
    {
        $this->set_clas_mesg();

        $this->set_point("group.add.name");
        
        $this->base_edit_mesg($opts,
            $opts->view->add_gls(),
            $opts->reply->add_gls()
        );
    }

    public function add_save_name_gls(opts $opts): void
    {
        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $gps_name = $this->valid()->rules(
            "alpha_dash", "min:5", "max:20"
        )->reply(
            "panel.group", "add"
        )->runing();

        ears()->set("gps.add", json_encode(["name" => $gps_name]));

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->add_save_name_gls())
            ->markup($opts->reply->add_save_name_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_show_title_gls(opts $opts): void
    {
        $this->set_point("group.add.title");

        $this->base_edit_mesg($opts,
            $opts->view->add_show_title_gls(),
            $opts->reply->add_show_title_gls()
        );
    }

    public function add_save_title_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $gps_title = $this->valid()->rules(
            "persian_alpha", "min:5", "max:20"
        )->reply(
            "panel.group", "confirm"
        )->runing();

        $data = collect(json_decode(ears()->get("gps.add"), true))
            ->put("title", $gps_title)->toJson();

        ears()->set("gps.add", $data);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->add_save_title_gls())
            ->markup($opts->reply->add_save_title_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_show_desc_gls(opts $opts): void
    {
        $this->set_point("group.add.desc");

        $this->base_edit_mesg($opts,
            $opts->view->add_show_desc_gls(),
            $opts->reply->add_show_desc_gls()
        );
    }

    public function add_save_desc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $gps_desc = $this->valid()->rules(
            "persian_alpha", "min:5", "max:255"
        )->reply(
            "panel.group", "confirm.two"
        )->runing();

        $data = collect(json_decode(ears()->get("gps.add"), true))
            ->put("desc", $gps_desc)->toJson();

        ears()->set("gps.add", $data);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->add_save_desc_gls())
            ->markup($opts->reply->add_save_desc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function add_parent_gls(opts $opts): void
    {
        $page = lesa()->cals_data_obj->args->page ?? 0;

        $this->set_type("add.parent");

        $this->base_edit_mesg($opts,
            $opts->view->add_parent_gls(),
            $opts->reply->add_parent_gls($page)
        );
    }

    public function add_status_gls(opts $opts): void
    {
        $this->reset_type();

        $gps_desc = lesa()->cals_data_obj->args->query;

        $data = collect(json_decode(ears()->get("gps.add"), true))
            ->put("parent", $gps_desc)->toJson();

        ears()->set("gps.add", $data);

        $this->base_edit_mesg($opts,
            $opts->view->add_status_gls(),
            $opts->reply->add_status_gls()
        );
    }

    public function add_create_gls(opts $opts): void
    {
        $gps_desc = lesa()->cals_data_obj->args->query;

        $data = collect(json_decode(ears()->get("gps.add"), true))
            ->put("status", $gps_desc)->toJson();

        ears()->set("gps.add", $data);

        $this->base_edit_mesg($opts,
            $opts->view->add_create_gls($data),
            $opts->reply->add_create_gls()
        );
    }

    public function add_create_proc_gls(opts $opts)
    {
        $info = json_decode(ears()->get("gps.add"));

        if(! group::where("name", $info->name)->exists())
        {
            $status = group::create([
                "name" => $info->name,
                "title" => $info->title,
                "parent" => ($info->parent == "nls") ? null : $info->parent,
                "status" => ($info->status == "yes") ? true : false,
            ]);
        }else{
            return false;
        }

        $this->base_edit_mesg($opts,
            $opts->view->add_create_proc_gls($status),
            $opts->reply->add_create_proc_gls()
        );
    }
}