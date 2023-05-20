<?php

namespace lord\plg\telg\reply\opts;

use lord\dbs\cog;
use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class select implements scope
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

    public function caps(string $caps): self
    {
        $this->tmps->get("caps")->put("flat", $caps);

        return $this;
    }

    public function cell(string $cell): self
    {
        $this->tmps->get("cell")->put("flat", $cell);

        return $this;
    }

    public function vals(): self
    {
        $this->tmps->get("vals")->push(func_get_args());

        return $this;
    }

    public function show(string $vid, string $show): self
    {
        $this->tmps->get("show")->put($vid, ["flat" => $show]);

        return $this;
    }

    public function args(string $key, mixed $val): self
    {
        $this->tmps->get("args")->push(compact("key", "val"));

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

    private function make_sole(): sole
    {
        return new sole();
    }

    private function gens_rule_sta(): string
    {
        return collect([
            "select", $this->tmps->object()->rule->flat, "status"
        ])->join(".");
    }

    private function gens_rule_cap(): string
    {
        return collect([
            "select", $this->tmps->object()->rule->flat, "caption"
        ])->join(".");
    }

    private function gens_show(string $val): string
    {
        $show = $this->tmps->get("show");

        return $show->has($val) ? $show->get($val)['flat'] : $val;
    }

    private function gens_args(string $val): collect
    {
        if ($this->tmps->get("args")->isNotEmpty()) {
            return collect($this->tmps->get("args"))->push([
                "key" => "status",
                "val" => $val
            ]);
        }

        return collect()->push([
            "key" => "status",
            "val" => $val
        ]);
    }

    private function gens_all(): array
    {
        return [
            "rule_sta" => $this->gens_rule_sta(),
            "rule_cap" => $this->gens_rule_cap(),
        ];
    }

    private function get_cog_val(): cog
    {
        return cog::where("name", $this->tmps->get("cell")->object()->flat)->first();
    }

    private function get_next_val(string $cog_data)
    {
        $vals = $this->tmps->get("vals")->flatten()->toArray();

        $postion = $this->tmps->get("vals")
            ->flatten()->flip()->get($cog_data);

        return ($postion >= (count($vals) - 1)) ? 0 : ($postion + 1);
    }

    public function get_tmps(): array
    {
        extract($this->gens_all());

        $cog_data = $this->get_cog_val();

        $postion = $this->get_next_val($cog_data->value);

        $postion_next_val = collect($this->tmps->get("vals"))
            ->flatten()->values()->get($postion);

        $make_sole_sta = $this->make_sole()->rule($rule_sta)
            ->show($this->gens_show($postion_next_val));

        $this->gens_args($postion_next_val)->each(function ($arg) use ($make_sole_sta) {
            $arg = collect($arg)->object();
            $make_sole_sta->args($arg->key, $arg->val);
        });

        $make_sole_cap = $this->make_sole()->rule($rule_cap)
            ->show($this->tmps->get("caps")->object()->flat);

        return [$make_sole_cap->get_tmps_two(), $make_sole_sta->get_tmps_two()];
    }
}