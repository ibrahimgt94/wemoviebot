<?php

namespace lord\plg\map;

use lord\aps\main\orgs\view as orgs_view;
use lord\aps\main\orgs\reply as orgs_reply;
use lord\aps\panel\user\orgs\view;
use lord\dbs\tmp;
use lord\plg\map\opts\node;
use Illuminate\Support\Collection as collect;
use lord\plg\telg\opts;
use lord\plg\telg\opts\answer\callback\query;
use Lord\plg\telg\telg;

/**
 * @property \lord\plg\map\opts\node $node
 */
class xroute extends edge
{
    private string $point;

    private string $point_nls;

    private array $funcs = [
        "node" => node::class,
    ];

    public function __construct()
    {
        $this->point_nls = hlps()->route("nls");

        $this->point = tmp::where("user_id", lesa()->chat_id)
                ->first()->point ?? $this->point_nls;
    }

    private function is_point_nls(): bool
    {
        return ($this->point == $this->point_nls);
    }

    private function get_point(): string
    {
        return $this->point;
    }

    public function __get(string $name)
    {
        return collect($this->funcs)->call($name);
    }

    private function get_save_maps(): collect
    {
        $maps_data = xdata()->get("maps");

        $hash_node_point_dbs = $this->get_point();

        $maps_data->has($hash_node_point_dbs) ?: (
            exit("hash {$hash_node_point_dbs} not exists")
        );

        return $maps_data->get($hash_node_point_dbs);
    }

    private function get_cals_maps(): collect
    {
        $maps_data = xdata()->get("maps");

        $hash_node_lesa = lesa()->cals_data_obj->node;

        $maps_data->has($hash_node_lesa) ?: (
            exit("hash {$hash_node_lesa} not exists")
        );

        return $maps_data->get($hash_node_lesa);
    }

    private function get_line_maps(): collect
    {
        return collect();
    }

    private function get_base_maps(): collect
    {
        return $this->is_point_nls() ? (
            $this->get_cmd_maps()
        ) : $this->get_save_maps();
    }

    private function get_node_info(collect $maps_data, string $mesg_hash): object
    {
        $node_data = $maps_data->pluck("node")->pluck("hash")->unique()->values();

        $node_data = $node_data->map(function ($node_hash) use ($mesg_hash) {
            $get_rule_node = collect([$mesg_hash, $node_hash])->filter()->join(".");

            return hlps()->route($get_rule_node);
        });

        $maps_node_hash = $maps_data->keys()->intersect($node_data);

        return collect([
            "node_hash" => $maps_node_hash->first(),
            "node_exists" => ($maps_node_hash->count() >= 1),
        ])->object();
    }

    private function reset_type(): bool
    {
        return tmp::where("user_id", lesa()->chat_id)
            ->update(["type" => null]);
    }

    private function get_cmd_maps(): collect
    {
        $mesg_hash = lesa()->mesg_text_hash;

        $maps_data = xdata()->get("maps");

        $infos = $this->get_node_info($maps_data, $mesg_hash);

        ($infos->node_exists) ?: exit("hash {$infos->node_hash} not exists");

        return $maps_data->get($infos->node_hash);
    }

    private function get_type_maps(string $type): collect
    {
        return match ($type) {
            "glass" => $this->get_cals_maps(),
            "line" => $this->get_line_maps(),
            "base" => $this->get_base_maps(),
        };
    }

    public function dispach()
    {
        $lesa_type = lesa()->get_type;

        ($lesa_type != "base") ?: (
            (lesa()->mesg_text_hash != "d572600f5") ?: $this->reset_type()
        );
    }

    public function execute(): void
    {
        $lesa_type = lesa()->get_type;

        $type_maps = $this->get_type_maps($lesa_type);

        $this->invoker($type_maps);
    }

    private function invoker(collect $map_datas): void
    {
        $map_targ_data = $map_datas->get("targ")->object();

        $class_path = str()->of($map_targ_data->class)
            ->replace(".", "\\")->__toString();

        $map_opts_targ_ary = str()->of($map_targ_data->class)
            ->explode(".")->toArray();

        array_pop($map_opts_targ_ary);

        $map_opts_targ_ary_view = collect($map_opts_targ_ary)
            ->push("view")->join("\\");

        $map_opts_targ_ary_reply = collect($map_opts_targ_ary)
            ->push("reply")->join("\\");

        $opts_clas = new opts();

        $opts_clas->view = app()->make($map_opts_targ_ary_view);

        $opts_clas->reply = app()->make($map_opts_targ_ary_reply);

        call_user_func_array([
            new $class_path, $map_targ_data->funcs
        ], [$opts_clas, $map_datas->get("args")]);
    }

    public function push_rule_data(collect $datas)
    {
        [$node_data, $rule_data, $prefix_data] = [
            xdata()->get("node")->object(),
            $datas->get("rule")->object(),
            $datas->get("prefix")->object()
        ];

        $prefix_data_hash = $datas->get("cogs")->object()->prefix ? (
            $prefix_data->hash ?? null
        ) : null;

        $rule_node_prefix = collect([
            $rule_data->hash, $prefix_data_hash, $node_data->hash
        ])->filter()->join(".");

        $targ_space = collect(["lord", "aps"]);

        $node_data_flat = str()->of($node_data->flat)->explode(".");

        $targ_class = $datas->get("prefix")->isEmpty() ? (
            $targ_space->merge($node_data_flat)
        ) : $targ_space->push($prefix_data->flat)->merge($node_data_flat);

        $targ_class_join = $targ_class->join(".");

        $targ_class_join_to_space = str()->of(
            $targ_class_join
        )->replace(".", "\\")->__toString();

        $targ_funcs = $datas->get("targ")->get("funcs");

        $targ_full = str()->of(
            $targ_class_join_to_space
        )->append("::")->append($targ_funcs)->__toString();

        $collect_targ = collect()->put("funcs", $targ_funcs)
            ->put("class", $targ_class_join)->put("path", $targ_full);

        $collect_map = collect()->put("node", $node_data)->put(
            "args", $datas->get("args")->object()
        )->put("targ", $collect_targ)->put("rule", $rule_data)->put("prefix", $prefix_data);

        xdata()->get("maps")->put(
            hlps()->route($rule_node_prefix), $collect_map
        );
    }
}