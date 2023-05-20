<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class pack implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "chunk" => 2,
        ]);
    }

    public function rule(string $rule): self
    {
        $this->tmps->get("rule")->put($rule, [
            "flat" => $rule,
            "hash" => hlps()->route($rule)
        ]);

        return $this;
    }

    public function show(string $rule, string $show): self
    {
        $this->tmps->get("show")->put($rule, [
            "flat" => $show
        ]);

        return $this;
    }

    public function args(string $rule, string $key, mixed $val): self
    {
        $this->tmps->get("args")->put($rule, compact("key", "val"));

        return $this;
    }

    private function make_sole(): sole
    {
        return new sole();
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

    public function get_tmps(): array
    {
        return $this->tmps->get("rule")->map(function ($rule) {
            $rule = collect($rule)->object();

            $make_sole = $this->make_sole()->rule($rule->flat);

            $make_sole->show($rule->flat);

            $show_data = $this->tmps->get("show");

            $show_data->has($rule->flat) ? (
                    $make_sole->show(
                        $show_data->get($rule->flat)['flat']
                    )
            ) : (
                $make_sole->show($rule->flat)
            );

            $args_data = $this->tmps->get("args");

            if ($args_data->has($rule->flat)) {
                $args = collect($args_data->get($rule->flat))->object();

                $make_sole->args($args->key, $args->val);
            }

            return $make_sole->get_tmps_two();
        })->toArray();
    }
}