<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;
use Illuminate\Database\Query\Builder as builder;

class listx extends query
{
    public function selcs(string $column, string $table = "lists"): self
    {
        $this->tmps->get("list")->put("table", $table)
            ->put("column", $column);

        return $this;
    }

    private function opts(string $type, string $when): self
    {
        $this->tmps->get("list")->put("type", $type)
            ->put("when", ears()->get($when));

        return $this;
    }

    public function opts_two(string $when, string $cell = "id"): self
    {
        $this->tmps->get("list")->put("type", "two")
            ->put("when", ears()->get($when))->put("cell", $cell);

        return $this;
    }

    private function get_data_type_one($tmps)
    {
        return dbs()->table($tmps->list->table)->where(
            "name", $tmps->list->column
        )->first()->value;
    }

    private function get_data_type_two($tmps)
    {
        return dbs()->table($tmps->list->table)->where(
            $tmps->list->cell, $tmps->list->when
        )->first()->{$tmps->list->column};
    }

    protected function gens_reply(collect $dbs_datas, object $tmps): array
    {
       $selcs = match ($tmps->list->type){
           "one" => $this->get_data_type_one($tmps),
           "two" => $this->get_data_type_two($tmps)
       };

       $selcs = unserialize($selcs);

        return $dbs_datas->map(function ($user) use ($tmps, $selcs) {
            $user_data = collect($user);

            $rule_cell_data = $this->gens_rule(
                $tmps, $user_data->get($tmps->dbs->cell)
            );

            $make_sole = $this->make_sole()->rule($rule_cell_data);

            $show_text = $user_data->get($tmps->dbs->show);

            (in_array($user->{$tmps->dbs->cell}, $selcs)) ? (
                $make_sole->show("{$show_text} \xF0\x9F\x9A\xA9")
            ) : $make_sole->show($show_text);

            $this->gens_args($user_data->get($tmps->dbs->cell))
                ->each(function ($arg) use ($make_sole) {
                    $arg = collect($arg)->object();
                    $make_sole->args($arg->key, $arg->val);
                });

            return $make_sole->get_tmps_two();
        })->toArray();
    }
}