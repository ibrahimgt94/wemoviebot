<?php

namespace lord\aps\main\orgs;

use lord\dbs\cog;
use lord\dbs\group;
use lord\dbs\movie;
use lord\dbs\tmp;
use lord\dbs\user;
use lord\fac\valid;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;

class eadg extends eage_clas
{
    public function __construct()
    {
        parent::__construct();

        map_auth::regis_new_user();
    }

    public function show_cmd(opts $opts): void
    {
        $this->set_type("gps.show.cmd");

        $this->base_send_mesg($opts,
            $opts->view->show_cmd(),
            $opts->reply->show_cmd()
        );
    }

    public function show_gls(opts $opts, $args): void
    {
        ears()->reset();

        $this->set_type("gps.show.cmd");

        $this->base_edit_mesg($opts,
            $opts->view->show_cmd(),
            $opts->reply->show_cmd($args)
        );
    }

    public function profile_gls(opts $opts): void
    {
        $profile = user::where(
            "id", lesa()->chat_id
        )->first();

        $bot_id = config("telg.robat");

        $this->base_edit_mesg($opts,
            $opts->view->profile_gls($bot_id, $profile),
            $opts->reply->profile_gls($bot_id, $profile->id)
        );
    }

    public function group_map_gls(opts $opts, $args): void
    {
        $query = lesa()->cals_data_obj->args->query;

        group::where("parent", $query)->exists() ? (
            $this->gps_type_one($opts, $args, $query)
        ) : $this->gps_type_two($opts, $args);
    }

    private function gps_type_one($opts, $args, $query): void
    {
        ears()->set("ptype", "chaild");

        $this->group_gls($opts, $args, $query);
    }

    private function gps_type_two($opts, $args): void
    {
        ears()->set("ptype", "parent");

        $this->movie_gls($opts, $args);
    }

    public function group_gls(opts $opts, $args, $query): void
    {
        $gps_data = group::where("id", $query)->first();

        $args = collect($args)->put("id", $gps_data->id)
            ->put("name", $gps_data->name)
            ->put("title", $gps_data->title)->put("page", 0)->object();

        $this->set_type("movie_gls");

        $this->base_edit_mesg($opts,
            $opts->view->group_gls($args),
            $opts->reply->group_gls($args)
        );
    }

    public function movie_gls(opts $opts, $args): void
    {
        ears()->set_query();

        $this->set_type("down_gls");

        $gps_data = group::where(
            "id", lesa()->cals_data_obj->args->query
        )->first();

        $this->base_edit_mesg($opts,
            $opts->view->movie_gls($gps_data->title),
            $opts->reply->movie_gls($args)
        );
    }

    private function replace_key($arr, $oldkey, $newkey) {
        if(array_key_exists( $oldkey, $arr)) {
            $keys = array_keys($arr);
            $keys[array_search($oldkey, $keys)] = $newkey;
            return array_combine($keys, $arr);
        }
        return $arr;
    }

    public function down_gls(opts $opts, $args): void
    {
        $this->reset_type();

        $movie = movie::with("downs")
            ->with("property")
            ->where("id", 52)->first();

        $propertys = collect($movie->property)
            ->forget("movie_id")->map(function ($val){
                $group = group::whereIn("id", unserialize($val))->get();

                return collect([
                    "title" => group::where(
                        "id", $group->pluck("parent")->first()
                    )->first()->title ?? null,
                    "data" => $group->pluck("title")->join(" - ")
                ])->object();
            })->filter(function ($datas){
                return array_filter(collect($datas)->toArray());
            });

        $is_search = lesa()->cals_data_obj->args->search ?? false;

        $this->base_edit_mesg($opts,
            $opts->view->down_gls($movie, $propertys),
            $opts->reply->down_gls($movie->downs, $is_search, $args)
        );
    }

    public function proposed_gls(opts $opts, $args): void
    {
        ears()->set("query", 2);

        ears()->set("ptype", "parent");

        $this->movie_gls($opts, $args);
    }

    public function popular_gls(opts $opts, $args): void
    {
        ears()->set("query", 3);

        ears()->set("ptype", "parent");

        $this->movie_gls($opts, $args);
    }

    public function help_gls(opts $opts, $args): void
    {
        $help_text = cog::where("name", "help.uniqid")->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->help_gls($help_text),
            $opts->reply->help_gls()
        );
    }

    public function support_gls(opts $opts, $args): void
    {
        $this->reset_type();

        $support_text = cog::where("name", "support.uniqid")->first()->value;

        $this->base_edit_mesg($opts,
            $opts->view->support_gls($support_text),
            $opts->reply->support_gls()
        );
    }

    public function search_gls(opts $opts, $args): void
    {
        ears()->set("mesg.id", lesa()->mesg_id);

        $this->set_point("search.movie");

        $this->reset_type();

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->search_gls(),
            $opts->reply->search_gls()
        );
    }

    public function search_proc_gls(opts $opts, $args): void
    {
        $this->reset_point();

        $this->set_type("down_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $valid_data = $this->valid()->rules("persian_alpha_num")
            ->reply("main", "search")->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_proc_gls())
            ->markup($opts->reply->search_proc_gls(
                $valid_data
            ))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }
}