<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class among implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "chunk" => 2,
            "cogs" => collect([
                "step" => 1
            ])
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

    public function step(int $step): self
    {
        $this->tmps->get("cogs")->put("step", $step);

        return $this;
    }

    public function show(int $digit, string $show): self
    {
        $this->tmps->get("show")->put($digit, ["flat" => $show]);

        return $this;
    }

    private function args_proc(mixed $index, string $key, mixed $val): self
    {
        $this->tmps->get("args")->put($index, compact("key", "val"));

        return $this;
    }

    public function args(int $digit, string $key, mixed $val): self
    {
        return $this->args_proc($digit, $key, $val);
    }

    public function args_all(string $key, mixed $val): self
    {
        return $this->args_proc("all", $key, $val);
    }

    private function make_sole(): sole
    {
        return new sole();
    }

    private function gens_rule(int $digit): string
    {
        return collect([
            "among", $this->tmps->object()->rule->flat, $digit
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

        (! $args->has("all")) ?: (
            $this->args($digit, ...$args->get("all"))
        );

        if ($args->has($digit)) {
            return collect()->push($args->get($digit))->push([
                "key" => "digit",
                "val" => $digit
            ]);
        }

        return collect()->push([
            "key" => "digit",
            "val" => $digit
        ]);
    }

    private function gens_range($cogs): array
    {
        return range($cogs->start, $cogs->end, $cogs->step);
    }

    private function gens_all(int $digit): array
    {
        return [
            "rule" => $this->gens_rule($digit),
            "show" => $this->gens_show($digit),
            "args" => $this->gens_args($digit)
        ];
    }

    public function get_chunk(): int
    {
        return $this->tmps->get("chunk");
    }

    public function get_tmps(): array
    {
        $tmps = $this->tmps->object();

        $rangs = $this->gens_range($tmps->cogs);

        return collect($rangs)->map(function ($digit) use ($tmps) {
            # rule, show, args
            extract($this->gens_all($digit));

            $make_sole = $this->make_sole()->rule($rule)->show($show);

            $args->each(function ($args) use ($make_sole) {
                $args = collect($args)->object();
                $make_sole->args($args->key, $args->val);
            });

            return $make_sole->get_tmps_two();
        })->toArray();
    }
}