<?php

namespace lord\aps\panel\movie\orgs;

use Illuminate\Database\Eloquent\Builder;
use lord\dbs\data;
use lord\dbs\down;
use lord\dbs\group;
use lord\dbs\listx;
use lord\dbs\movie;
use stdclass;
use lord\dbs\property;
use lord\dbs\tmp;
use lord\plg\telg\opts;
use lord\plg\telg\eage_clas;
use lord\fac\plg\map\auth as map_auth;
use lord\pro\ears;
use lord\pro\lesa;

class eadg extends eage_clas
{
    public function show_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->show_gls()
        );
    }

    public function search_gls(opts $opts): void
    {
        $this->reset_type();

        $this->set_point("movie.search");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->search_gls(),
            $opts->reply->search_gls()
        );
    }

    public function search_proc_gls(opts $opts): void
    {
        $this->reset_point();

        $this->set_type("list_gls");

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $search = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:30"
        )->reply(
            "panel.movie", "search"
        )->runing();

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->search_proc_gls())
            ->markup($opts->reply->search_proc_gls($search))->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function list_gls(opts $opts, $args): void
    {
        $this->set_type("list_gls");

        $this->base_edit_mesg($opts,
            $opts->view->list_gls(),
            $opts->reply->list_gls($args)
        );
    }

    private function send_post_to_site($args): bool
    {
        return false;
    }

    public function sendsite_gls(opts $opts, $args): void
    {
        $status = $this->send_post_to_site($args);

        $this->base_edit_mesg($opts,
            $opts->view->sendsite_gls($status),
            $opts->reply->sendsite_gls()
        );
    }

    private function prepare_post_channel($args)
    {
        $movie = movie::with("property")->where("id", 52)->first();

        $director = hlps()->convert_serialize_to_string($movie->property->director);

        return "عنوان فیلم : {$movie->title} \n کارگردان ها : {$director}";
    }

    private function send_post_to_channel($args): bool
    {
        return telg()->send_mesg->chat_id(
            config()->get("telg")['channel']
        )->text(
            $this->prepare_post_channel($args)
        )->exec()->ok;
    }

    public function sendchannel_gls(opts $opts, $args): void
    {
        $status = $this->send_post_to_channel($args);

        $this->base_edit_mesg($opts,
            $opts->view->sendchannel_gls($status),
            $opts->reply->sendchannel_gls()
        );
    }

    public function list_show_gls(opts $opts, $ears, $draft_id = null): void
    {
        $this->reset_type();

        $query_id = is_null($draft_id) ? (
            lesa()->cals_data_obj->args->query
        ) : ears()->get("movie.draft.id");

        ears()->set("movie.id", $query_id);

        $this->base_edit_mesg($opts,
            $opts->view->list_show_gls(),
            $opts->reply->list_show_gls((! is_null($draft_id)))
        );
    }

    public function dels_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->dels_gls(),
            $opts->reply->dels_gls()
        );
    }

    public function dels_proc_gls(opts $opts): void
    {
        $movie_id = ears()->get("movie.id");

        $movie = movie::where("id", $movie_id);

        property::where("movie_id", $movie_id)->delete();

        $movie->first()->groups()->detach();

        $status = $movie->delete();

        $this->base_edit_mesg($opts,
            $opts->view->dels_proc_gls($status),
            $opts->reply->dels_proc_gls()
        );
    }

    public function image_gls(opts $opts): void
    {
        $this->set_point("image.gls");

        $this->set_clas_mesg();

        $image = $this->get_dbs_movie()->first()->image;

        telg()->edit_mesg->chat_id()->mesg_id()
            ->text($opts->view->image_gls())
            ->markup($opts->reply->image_gls($image))->exec();

        $opts->query->exec();
    }

    public function image_proc_gls(opts $opts)
    {
        $this->reset_point();

        $photo = collect(lesa()->photo_ary)->last();

        $photo = telg()->get_file->down_fild_id($photo->fid);

        $proc_status = ($photo == false) ? false : (
            $this->get_dbs_movie()->update(["image" => $photo])
        );

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->image_proc_gls($proc_status))
            ->markup($opts->reply->image_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function title_gls(opts $opts): void
    {
        $this->set_point("title.gls");

        $this->set_clas_mesg();

        $title = $this->get_dbs_movie()->first()->title;

        $this->base_edit_mesg($opts,
            $opts->view->title_gls($title),
            $opts->reply->title_gls()
        );
    }

    public function title_proc_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $title = $this->valid()->rules(
            "persian_alpha_num", "min:5", "max:20"
        )->reply(
            "panel.movie", "title"
        )->runing();

        $proc_status = $this->get_dbs_movie()->update(["title" => $title]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->title_proc_gls($proc_status))
            ->markup($opts->reply->title_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function summary_gls(opts $opts): void
    {
        $this->set_point("summary.gls");

        $this->set_clas_mesg();

        $summary = $this->get_dbs_movie()->first()->summary;

        $this->base_edit_mesg($opts,
            $opts->view->summary_gls($summary),
            $opts->reply->summary_gls()
        );
    }

    public function summary_proc_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $summary = $this->valid()->rules(
            "string", "min:5", "max:1024"
        )->reply(
            "panel.movie", "summary"
        )->runing();

        $proc_status = $this->get_dbs_movie()->update(["summary" => $summary]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->summary_proc_gls($proc_status))
            ->markup($opts->reply->summary_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function status_gls(opts $opts): void
    {
        $status = $this->get_dbs_movie()->first()->status;

        $status_ti = ($status == 1) ? "فیلم نمایش داده می شود" : "فیلم نمایش داده نمی شود";

        $this->base_edit_mesg($opts,
            $opts->view->status_gls($status_ti),
            $opts->reply->status_gls($status)
        );
    }

    public function status_proc_gls(opts $opts): void
    {
        $type_sta = (lesa()->cals_data_obj->args->type == "on") ? true : false;

        $status = movie::where("id", ears()->get("movie.id"))
            ->update(["status" => $type_sta]);

        $this->base_edit_mesg($opts,
            $opts->view->status_proc_gls($status),
            $opts->reply->status_proc_gls()
        );
    }

    public function group_gls(opts $opts, $args): void
    {
        $this->set_type("group_gls");

        $this->auto_list("movie.gps");

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->group_gls($args)
        );
    }

    public function down_gls(opts $opts, $args): void
    {
        $this->set_type("down_gls");

        ears()->flush("movie.down.id");

        $this->reset_point();

        $hand = listx::where("name", "down.add.addr");

        (! $hand->exists()) ?: $hand->delete();

        $this->base_edit_mesg($opts,
            $opts->view->down_gls(),
            $opts->reply->down_gls($args)
        );
    }

    public function down_add_addr_gls(opts $opts, $args): void
    {
        $this->set_type("down_add_addr_gls");

        $this->base_edit_mesg($opts,
            $opts->view->down_add_addr_gls(),
            $opts->reply->down_add_addr_gls($args)
        );
    }

    public function down_add_addr_two_gls(opts $opts): void
    {
        $this->reset_type();

        $this->set_point("down.add.addr");

        $query = lesa()->cals_data_obj->args->query;

        ears()->set("down.add.addr", $query);

        listx::puting("down.add.addr", [
            "title" => $query,
            "direct" => ($query == "ups1"),
        ]);

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->down_add_addr_two_gls(),
            $opts->reply->down_add_addr_two_gls()
        );
    }

    public function down_add_addr_three_gls(opts $opts)
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $addr_text = $this->valid()->rules(
            "url", "min:5", "max:255"
        )->reply(
            "panel.movie", "back.downs"
        )->runing();

        listx::puting("down.add.addr", ["addrs" => $addr_text]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_add_addr_three_gls())
            ->markup($opts->reply->down_add_addr_three_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_add_addr_for_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->down_add_addr_for_gls(),
            $opts->reply->down_add_addr_for_gls()
        );
    }

    public function down_add_addr_fiv_gls(opts $opts): void
    {
        listx::puting("down.add.addr", [
            "status" => lesa()->cals_data_obj->args->type ?? 0
        ]);

        $is_direct = listx::getting("down.add.addr", "direct");

        $this->base_edit_mesg($opts,
            $opts->view->down_add_addr_fiv_gls(),
            $opts->reply->down_add_addr_fiv_gls($is_direct)
        );
    }

    public function down_add_addr_proc_gls(opts $opts): void
    {
        $hand = listx::where("name", "down.add.addr");

        $vals = unserialize($hand->first()->value);

        $down_title = unserialize(data::where("name", "down.title")->first()->value);

        $vals['title'] = $down_title[$vals['title']] ?? "نامشخص";

        $vals['type'] = $vals['direct'];

        unset($vals['direct']);

        $insert_id = dbs()->table("downs")->insertGetId($vals);

        movie::where("id", ears()->get("movie.id"))
            ->first()->downs()->attach($insert_id);

        $proc_status = dbs()->table("downs")->where("id", $insert_id)->exists();

        $hand->delete();

        $this->base_edit_mesg($opts,
            $opts->view->down_add_addr_proc_gls($proc_status),
            $opts->reply->down_add_addr_proc_gls()
        );
    }

    public function down_add_addr_auto_proc_gls(opts $opts): void
    {
        # upload file to, telegram chanel, uploadboy, server

        $this->base_edit_mesg($opts,
            $opts->view->show_gls(),
            $opts->reply->down_add_addr_proc_gls()
        );
    }

    public function down_show_gls(opts $opts): void
    {
        $this->reset_type();

        $this->reset_point();

        ears()->set("movie.down.id", lesa()->cals_data_obj->args->query);

        $this->base_edit_mesg($opts,
            $opts->view->down_show_gls(),
            $opts->reply->down_show_gls()
        );
    }

    public function down_delete_gls(opts $opts): void
    {
        $this->base_edit_mesg($opts,
            $opts->view->down_delete_gls(),
            $opts->reply->down_delete_gls()
        );
    }

    public function down_delete_proc_gls(opts $opts): void
    {
        $proc_sta = down::where("id", ears()->get("movie.down.id"))->delete();

        $this->base_edit_mesg($opts,
            $opts->view->down_delete_proc_gls($proc_sta),
            $opts->reply->down_delete_proc_gls()
        );
    }

    public function down_edit_title_gls(opts $opts, $args): void
    {
        $this->set_type("down_edit_title_gls");

        $this->set_clas_mesg();

        $is_direct = down::where(
            "id", ears()->get("movie.down.id")
        )->first()->type;

        $this->base_edit_mesg($opts,
            $opts->view->down_edit_title_gls(),
            $opts->reply->down_edit_title_gls($is_direct, $args)
        );
    }

    public function down_edit_title_proc_gls(opts $opts): void
    {
        $this->reset_type();

        $title = data::get_value_data("down.title");

        $type = (lesa()->cals_data_obj->args->query == "ups1");

        $proc_status = down::where("id", ears()->get("movie.down.id"))
            ->update(["title" => $title, "type" => $type]);

        $this->base_edit_mesg($opts,
            $opts->view->down_edit_title_proc_gls($proc_status),
            $opts->reply->down_edit_title_proc_gls()
        );
    }

    public function down_edit_addrs_gls(opts $opts): void
    {
        $this->set_point("edit.addrs");

        $this->set_clas_mesg();

        $this->base_edit_mesg($opts,
            $opts->view->down_edit_addrs_gls(),
            $opts->reply->down_edit_addrs_gls()
        );
    }

    public function down_edit_addrs_proc_gls(opts $opts): void
    {
        $this->reset_point();

        [$cals_id, $mesg_id] = $this->get_cals_mesgid($opts);

        $addr_text = $this->valid()->rules(
            "url", "min:5", "max:255"
        )->reply(
            "panel.movie", "back.downs.show", [
                "query" => ears()->get("movie.down.id")
            ])->runing();

        $proc_status = down::where("id", ears()->get("movie.down.id"))
            ->update(["addrs" => $addr_text]);

        $opts->telg->edit_mesg->chat_id()->mesg_id($mesg_id)
            ->text($opts->view->down_edit_addrs_proc_gls($proc_status))
            ->markup($opts->reply->down_edit_addrs_proc_gls())->exec();

        $opts->query->callback_query_id($cals_id)->exec();
    }

    public function down_edit_status_gls(opts $opts): void
    {
        $status = down::where("id", ears()->get("movie.down.id"))->first()->status;

        $status_ti = ($status == 1 ) ? "لینک قایل نمایش است" : "لینک قایل نمایش نیست";

        $this->base_edit_mesg($opts,
            $opts->view->down_edit_status_gls($status_ti),
            $opts->reply->down_edit_status_gls($status)
        );
    }

    public function down_edit_status_proc_gls(opts $opts): void
    {
        $type_sta = lesa()->cals_data_obj->args->type == "on" ? true : false;

        $proc_sta = down::where("id", ears()->get("movie.down.id"))->update(["status" => $type_sta]);

        $this->base_edit_mesg($opts,
            $opts->view->down_edit_status_proc_gls($proc_sta),
            $opts->reply->down_edit_status_proc_gls()
        );
    }

    public function property_gls(opts $opts): void
    {
        $this->reset_point();

        $this->reset_type();

        $this->base_edit_mesg($opts,
            $opts->view->property_gls(),
            $opts->reply->property_gls()
        );
    }

    private function toggel_group_movie(): void
    {
        $movie = movie::where("id", ears()->get("movie.id"))->first();

        $movie->groups()->toggle(lesa()->cals_data_obj->args->query);
    }

    private function toggel_group_movie_solo(string $type): void
    {
        $movie = movie::where("id", ears()->get("movie.id"))->first();

        $new_nums = lesa()->cals_data_obj->args->query ?? null;

        $old_nums = collect(unserialize($movie->property()->first()->{$type}));

        if($old_nums->contains($new_nums)){
            $movie->groups()->toggle($new_nums);
        }else{
            if(! is_null($new_nums))
            {
                $movie->groups()->toggle(
                    $old_nums->merge($new_nums)->toArray()
                );
            }
        }
    }

    public function director_gls(opts $opts, $args): void
    {
        $this->set_type("director_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "director"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->director_gls(),
            $opts->reply->director_gls($args)
        );
    }

    public function producer_gls(opts $opts, $args): void
    {
        $this->set_type("producer_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "producer"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->producer_gls(),
            $opts->reply->producer_gls($args)
        );
    }

    public function writer_gls(opts $opts): void
    {
        $this->set_type("writer_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "writer"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->writer_gls(),
            $opts->reply->writer_gls()
        );
    }

    public function year_gls(opts $opts, $args): void
    {
        $this->set_type("year_gls");

        $this->toggel_group_movie_solo("year");

        $this->auto_flex_solo(
            "propertys", "movie_id",
            ears()->get("movie.id"), "year"
        );

        $this->base_edit_mesg($opts,
            $opts->view->year_gls(),
            $opts->reply->year_gls($args)
        );
    }

    public function filming_gls(opts $opts): void
    {
        $this->set_type("filming_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "filming"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->filming_gls(),
            $opts->reply->filming_gls()
        );
    }

    public function singer_gls(opts $opts): void
    {
        $this->set_type("singer_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "singer"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->singer_gls(),
            $opts->reply->singer_gls()
        );
    }

    public function actors_gls(opts $opts): void
    {
        $this->set_type("actors_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "actors"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->actors_gls(),
            $opts->reply->actors_gls()
        );
    }

    public function duration_gls(opts $opts): void
    {
        $this->set_type("duration_gls");

        $this->toggel_group_movie_solo("duration");

        $this->auto_flex_solo(
            "propertys", "movie_id",
            ears()->get("movie.id"), "duration"
        );

        $this->base_edit_mesg($opts,
            $opts->view->duration_gls(),
            $opts->reply->duration_gls()
        );
    }

    public function asong_gls(opts $opts): void
    {
        $this->set_type("asong_gls");

        $this->auto_flex(
            "propertys", "movie_id",
            ears()->get("movie.id"), "asong"
        );

        $this->toggel_group_movie();

        $this->base_edit_mesg($opts,
            $opts->view->asong_gls(),
            $opts->reply->asong_gls()
        );
    }

    # section add movie #

    private function crate_movie()
    {
        $last_insert_id = dbs()->table("movies")
            ->insertGetId([
                "title" => "",
                "image" => "",
                "summary" => "",
                "is_draft" => true,
                "status" => false
            ]);

        property::insert([
            "movie_id" => $last_insert_id
        ]);

        ears()->set("movie.draft.id", $last_insert_id);

        ears()->set("movie.draft.has", true);

        return movie::where("id", $last_insert_id)->exists();
    }

    private function get_dbs_movie(): Builder
    {
        return movie::where("id", ears()->get("movie.id"));
    }

    public function add_show_gls(opts $opts): void
    {
        ears()->except([
            "movie.draft.id",
            "movie.draft.has",
        ])->reset();

        $is_draft = ears()->get("movie.draft.has") ?? false;

        $this->base_edit_mesg($opts,
            $opts->view->add_show_gls(),
            $opts->reply->add_show_gls($is_draft)
        );
    }

    public function add_mory_draft_gls(opts $opts, $ears): void
    {
        $draft_id = ears()->get("movie.draft.id");

        $this->list_show_gls($opts, $ears, $draft_id);
    }

    public function add_del_draft_gls(opts $opts, $ears): void
    {
        $draft_id = ears()->get("movie.draft.id");

        $movie = movie::where("id", $draft_id);

        $is_draft = ($movie->first()->is_draft ?? false);

        if($is_draft == true){
            property::where("movie_id", $draft_id)->delete();

            $movie->first()->groups()->detach();

            $movie->delete();

            $status = true;
        }else{
            $status = false;
        }

        ears()->reset_force();

        $draft_id = $this->crate_movie();

        $this->list_show_gls($opts, $ears, $draft_id);
    }

    public function add_draft_save_gls(opts $opts): void
    {
        $movie_data = movie::where(
            "id", ears()->get("movie.id")
        )->first();

        if(empty($movie_data->title)){
            $view = $opts->view->add_draft_save_err_gls();

            $reply = $opts->reply->add_draft_save_err_gls();
        }else{
            $view = $opts->view->add_draft_save_gls();

            $reply = $opts->reply->add_draft_save_gls();

            $this->get_dbs_movie()->update([
                "is_draft" => false
            ]);

            ears()->reset_force();
        }

        $this->base_edit_mesg($opts, $view, $reply);
    }
}