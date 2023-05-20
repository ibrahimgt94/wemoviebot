<?php

namespace lord\plg\telg;

use Illuminate\Support\Facades\Validator;
use lord\dbs\listx;
use lord\dbs\tmp;
use Illuminate\Database\Eloquent\Builder as builder;
use lord\hlp\valid;
use ReflectionClass as reflect_class;

abstract class eage_clas
{
    private builder $dbs_tmps;

    public function __construct()
    {
        $this->dbs_tmps = tmp::where("user_id", lesa()->chat_id);
    }

    public function base_edit_mesg($opts, $text, $reply): void
    {
        $opts->telg->edit_mesg->chat_id()->mesg_id()
            ->text($text)->markup($reply)->exec();

        $opts->query->exec();
    }

    public function base_send_mesg($opts, $text, $reply): void
    {
        $opts->telg->send_mesg->chat_id()
            ->text($text)->markup($reply)->exec();
    }

    protected function set_type(string $type): void
    {
        $this->dbs_tmps->update(["type" => hlps()->route($type)]);
    }

    protected function reset_type(): void
    {
        $this->dbs_tmps->update(["type" => null]);
    }

    private function get_class_name(): string
    {
        return (new reflect_class($this))->getShortName();
    }

    protected function set_point(string $point): void
    {
        $rule_flat = collect()->push("save")
            ->push($point)->push($this->get_class_name())->join(".");

        $rule_hash = hlps()->route($rule_flat);

        $space_trim = str()->of(get_class($this))
            ->explode("\\")->splice(2)->join(".");

        $space_trim = hlps()->route($space_trim);

        $point = collect()->push($rule_hash)
            ->push($space_trim)->join(".");

        $this->dbs_tmps->update(["point" => hlps()->route($point)]);
    }

    protected function reset_point(): void
    {
        $this->dbs_tmps->update(["point" => hlps()->route("nls")]);
    }

    protected function reset_all(): void
    {
        $this->dbs_tmps->update([
            "type" => null,
            "point" => hlps()->route("nls"),
            "args" => null,
            "mesg" => null,
            "cals" => null,
        ]);
    }

    protected function set_clas_mesg(): void
    {
        tmp::where("user_id", lesa()->chat_id)->update([
            "cals" => lesa()->cals_id,
            "mesg" => lesa()->mesg_id
        ]);
    }

    protected function auto_list(string $column): void
    {
        $key_query = lesa()->cals_data_obj->args->query ?? null;

        if(! is_null($key_query)) {
            $list_dbs = listx::where("name", $column);

            $gps_data = collect(unserialize($list_dbs->first()->value));

            $gps_data_when = ($gps_data->contains($key_query)) ? (
                $gps_data->filter()->flip()->forget($key_query)->flip()
            ) : $gps_data->push($key_query);

            $list_dbs->update(["value" => serialize($gps_data_when->filter()->toArray())]);
        }
    }

    protected function auto_flex(string $table, string $when_key, string $when_val, string $cell)
    {
        $key_query = lesa()->cals_data_obj->args->query ?? null;

        if(! is_null($key_query)){
            $list_dbs = dbs()->table($table)->where($when_key, $when_val);

            $gps_data = collect(unserialize($list_dbs->first()->{$cell}));

            $gps_data_when = ($gps_data->contains($key_query)) ? (
                $gps_data->filter()->flip()->forget($key_query)->flip()
            ) : $gps_data->push($key_query);

            $list_dbs->update([$cell => serialize($gps_data_when->filter()->toArray())]);
        }
    }

    protected function auto_flex_solo(string $table, string $when_key, string $when_val, string $cell)
    {
        $key_query = lesa()->cals_data_obj->args->query ?? null;

        if(! is_null($key_query)){
            $list_dbs = dbs()->table($table)->where($when_key, $when_val);

            $gps_data = collect(unserialize($list_dbs->first()->{$cell}));

            $gps_data_when = ($gps_data->contains($key_query)) ? (
                $gps_data->filter()->flip()->forget($key_query)->flip()
            ) : collect()->push($key_query);

            $list_dbs->update([$cell => serialize($gps_data_when->filter()->toArray())]);
        }
    }


    protected function get_cals_mesgid(opts $opts): array
    {
        $opts->telg->dele_mesg->mesg_id()->chat_id()->exec();

        return $this->get_tmp_dbs_info();
    }

    protected function get_tmp_dbs_info(): array
    {
        $user_tmp = tmp::where("user_id", lesa()->chat_id)->first();

        return [$user_tmp->cals, $user_tmp->mesg];
    }

    protected function ready_data(): array
    {
        return ["data" => lesa()->mesg_text];
    }

    protected function valid(): valid
    {
        $text_data = $this->ready_data();

        $tmps_dbs = $this->get_tmp_dbs_info();

        return new valid($text_data, $tmps_dbs);
    }
}