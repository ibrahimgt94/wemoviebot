<?php

namespace lord\plg\map\opts;

use Illuminate\Support\Collection as collect;

abstract class edge
{
    protected collect $datas;

    public function __construct()
    {
        $this->datas = collect([
            "rule" => collect(),
            "prefix" => collect(),
            "targ" => collect([
                "cap" => null,
                "sta" => null,
            ]),
            "args" => collect(),
            "type" => collect(),
            "dbs" => collect(),
            "nums" => collect(),
            "pack" => collect(),
            "among" => collect([
                "start" => 0,
                "end" => 0,
                "step" => 1
            ]),
            "cogs" => collect([
                "prefix" => true,
                "is_data" => false,
            ]),
        ]);
    }

    public function rule(string $rule): self
    {
        $this->datas->get("rule")->put("flat", $rule)
            ->put("hash", hlps()->route($rule));

        return $this;
    }

    public function prefix(): self
    {
        $prefix = collect(func_get_args())->join(".");

        $this->datas->get("prefix")->put("flat", $prefix)
            ->put("hash", hlps()->route($prefix));

        return $this;
    }

    public function targ(string $targ): self
    {
        $this->datas->get("targ")->put("funcs", $targ);

        return $this;
    }

    public function args(string $key, mixed $value): self
    {
        $this->datas->get("args")->put($key, $value);

        return $this;
    }

    protected function not_use_prefix(collect $datas): collect
    {
        $collect_data = collect($datas);

        $prefix_off = $collect_data->get("cogs")->put("prefix", false);

        return $collect_data->put("cogs", $prefix_off);
    }

    protected function get_trim_keys(): collect
    {
        return collect($this->datas)->only(
            "rule", "args", "targ", "prefix", "cogs"
        );
    }

}