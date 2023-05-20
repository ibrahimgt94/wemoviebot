<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class sole implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "chunk" => 2,
            "revers" => false,
        ]);
    }

    public function rule(string $rule): self
    {
        $this->tmps->get("rule")->put("flat", $rule)
            ->put("hash", hlps()->route($rule));

        return $this;
    }

    public function show(string $show): self
    {
        $this->tmps->get("show")->put("flat", $show);

        return $this;
    }

    public function args(string $key, mixed $val): self
    {
        $this->tmps->get("args")->put($key, $val);

        return $this;
    }

    public function revers(): self
    {
        $this->tmps->put("revers", true);

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

    public function get_tmps_two(): object
    {
        return $this->tmps->object();
    }

    public function get_tmps(): array
    {
        return [$this->tmps->object()];
    }
}