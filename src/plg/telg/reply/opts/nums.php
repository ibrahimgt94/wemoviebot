<?php

namespace lord\plg\telg\reply\opts;

use lord\dbs\cog;
use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class nums implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "args_all" => collect(),
            "cogs" => collect([
                "step" => 1,
                "current" => 1,
                "type" => "increase",
                "before" => "number",
                "after" => "number",
                "cap_before_sta" => false,
                "cap_after_sta" => false,
            ]),
            "chunk" => 2,
            "caps" => collect([
                "flat" => "nums"
            ]),
            "data_auto" => false,
        ]);
    }

    public function rule(string $rule): self
    {
        $this->tmps->get("rule")->put("flat", $rule)
            ->put("hash", hlps()->route($rule));

        return $this;
    }

    public function start(int $start): self
    {
        $this->tmps->get("cogs")->put("start", $start);

        return $this;
    }

    public function data(int $data): self
    {
        $this->tmps->get("cogs")->put("current", $data);

        return $this;
    }

    public function data_cell(string $cell): self
    {
        $this->tmps->put("data_auto", true)
            ->put("cell", $cell);

        return $this;
    }

    public function end(int $end): self
    {
        $this->tmps->get("cogs")->put("end", $end);

        return $this;
    }

    public function chunk(int $chunk): self
    {
        $this->tmps->put("chunk", $chunk);

        return $this;
    }

    public function before(string $before): self
    {
        $this->tmps->get("cogs")->put("before", $before)
            ->put("cap_before_sta", true);

        return $this;
    }

    public function after(string $after): self
    {
        $this->tmps->get("cogs")->put("after", $after)
            ->put("cap_after_sta", true);

        return $this;
    }

    public function caps(string $caps): self
    {
        $this->tmps->get("caps")->put("flat", $caps);

        return $this;
    }

    public function step(int $step): self
    {
        $this->tmps->get("cogs")->put("step", $step);

        return $this;
    }

    public function increase(): self
    {
        return $this->type(__function__);
    }

    public function decrease(): self
    {
        return $this->type(__function__);
    }

    private function type(string $type): self
    {
        $this->tmps->get("cogs")->put("type", $type);

        return $this;
    }

    public function show(int $digit, string $show): self
    {
        $this->tmps->get("show")->put($digit, ["flat" => $show]);

        return $this;
    }

    public function args(int $digit, string $key, mixed $val): self
    {
        $this->tmps->get("args")->put($digit, compact("key", "val"));

        return $this;
    }

    public function args_all(string $key, mixed $val): self
    {
        $this->tmps->get("args_all")->put($key, $val);

        return $this;
    }

    private function make_sole(): sole
    {
        return new sole();
    }

    private function gens_rule_sta(int $digit): string
    {
        return collect([
            "nums", $this->tmps->object()->rule->flat, $digit, "status"
        ])->join(".");
    }

    private function gens_rule_cap(): string
    {
        return collect([
            "nums", $this->tmps->object()->rule->flat, "caption"
        ])->join(".");
    }

    private function gens_show(int $digit): string
    {
        $show = $this->tmps->get("show");

        return $show->has($digit) ? $show->get($digit)['flat'] : $digit;
    }

    private function gens_args(int $digit): collect
    {
        $args = $this->tmps->get("args");

        if ($args->has($digit)) {
            return collect()->push($args->get($digit))->push([
                "key" => "nums",
                "val" => $digit
            ]);
        }

        return collect()->push([
            "key" => "nums",
            "val" => $digit
        ]);
    }

    private function gens_all(int $digit): array
    {
        return [
            "rule" => $this->gens_rule($digit),
            "show" => $this->gens_show($digit),
            "args" => $this->gens_args($digit)
        ];
    }

    private function get_next_val(array $range, int $current)
    {
        $postion = collect($range)->flip()->get($current);

        return ($postion >= (count($range) - 1)) ? 0 : ($postion + 1);
    }

    public function get_chunk(): int
    {
        return $this->tmps->get("chunk");
    }

    public function get_tmps(): array
    {
        $cell = $this->tmps->get("cell");

        $def_val = $this->tmps->get("cogs")->get("start");

        if(! cog::where("name", $cell)->exists()) {
            cog::insert(["name" => $cell, "value" => $def_val]);
        }

        $data = cog::where("name", $cell)->first()->value ?? $def_val;

        $this->tmps->get("cogs")->put("current", $data);

        $tmps = $this->tmps->object();

        $start = $tmps->cogs->start;
        $end = $tmps->cogs->end;
        $step = $tmps->cogs->step;
        $current = $tmps->cogs->current;

        $rangs = ($tmps->cogs->type == "decrease") ? (
            range($end, $start, $step)
        ) : range($start, $end, $step);

        $postion = $this->get_next_val($rangs, $current);

        $postion_next_val = collect($rangs)->values()->get($postion);

        $rule_sta = $this->gens_rule_sta($postion_next_val);

        $rule_cap = $this->gens_rule_cap();

        $get_show_nums = $this->gens_show($postion_next_val);

        $get_show_nums_icon = collect()
            ->when($tmps->cogs->cap_before_sta, function ($collect) use ($tmps) {
                return $collect->push($tmps->cogs->before);
            })->push($current)
            ->when($tmps->cogs->cap_after_sta, function ($collect) use ($tmps) {
                return $collect->push($tmps->cogs->after);
            })->join(" ");

        $make_sole_sta = $this->make_sole()->rule($rule_sta)->show($get_show_nums_icon);

        $this->gens_args($postion_next_val)->each(function ($arg) use ($make_sole_sta) {
            $arg = collect($arg)->object();
            $make_sole_sta->args($arg->key, $arg->val);
        });

        $this->tmps->get("args_all")->each(function ($val, $key) use($make_sole_sta){
            $make_sole_sta->args($key, $val);
        });

        $make_sole_cap = $this->make_sole()->rule($rule_cap)
            ->show($this->tmps->get("caps")->object()->flat);

        return [$make_sole_cap->get_tmps_two(), $make_sole_sta->get_tmps_two()];
    }
}