<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class status implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "cell" => collect(),
            "vals" => collect(),
            "caps" => collect(),
            "chunk" => 2,
        ]);
    }

    public function rule(string $rule): self
    {
        $this->tmps->get("rule")->put("flat", $rule)
            ->put("hash", hlps()->route($rule));

        return $this;
    }

    public function cell(string $cell): self
    {
        $this->tmps->get("cell")->put("flat", $cell);

        return $this;
    }

    public function caps(string $caps): self
    {
        $this->tmps->get("caps")->put("flat", $caps);

        return $this;
    }

    public function chunk(int $chunk): self
    {
        $this->tmps->put("chunk", $chunk);

        return $this;
    }

    public function get_chunk(): int
    {
        return $this->tmps->get("chunk");
    }

    private function show(string $vid, string $show): self
    {
        $this->tmps->get("show")->put($vid, ["flat" => $show]);

        return $this;
    }

    public function enable(string $show): self
    {
        return $this->show(__function__, $show);
    }

    public function disable(string $show): self
    {
        return $this->show(__function__, $show);
    }

    public function args(string $key, mixed $val): self
    {
        $this->tmps->get("args")->push(compact("key", "val"));

        return $this;
    }

    private function make_select(): select
    {
        return new select();
    }

    public function get_tmps(): array
    {
        $tmps = $this->tmps->object();

        $make_select = $this->make_select()->rule($tmps->rule->flat)
            ->cell($tmps->cell->flat)->vals("enable", "disable");

        empty($tmps->caps) ? $make_select->caps("status") : (
            $make_select->caps($tmps->caps->flat)
        );

        collect($tmps->args)->each(function ($arg) use ($make_select) {
            $arg = collect($arg)->object();
            $make_select->args($arg->key, $arg->val);
        });

        collect($tmps->show)->each(function ($val, $key) use ($make_select) {
            $make_select->show($key, $val->flat);
        });

        return $make_select->get_tmps();
    }
}