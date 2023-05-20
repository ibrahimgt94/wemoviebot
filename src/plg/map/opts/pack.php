<?php

namespace lord\plg\map\opts;

use Illuminate\Support\Collection as collect;

class pack extends edge
{
    public function rule(string $rule): self
    {
        return $this;
    }

    public function pack(): self
    {
        $this->datas->get("pack")->push(func_get_args());

        return $this;
    }

    public function page(string $rule): self
    {
        return $this->pack(
            $rule,
            "{$rule}.page.next",
            "{$rule}.page.prev"
        );
    }

    public function pages(array $rules): self
    {
        collect($rules)->each(function ($rule){
            $this->datas->get("pack")->push([
                $rule,
                "{$rule}.page.next",
                "{$rule}.page.prev"
            ]);
        });

        return $this;
    }

    public function __destruct()
    {
        collect($this->datas)->get("pack")
            ->flatten()->each(function ($rule) {
                $this->add_rule_to_datas($rule);
            });
    }

    private function add_rule_to_datas($rule)
    {
        collect($this->datas)->get("rule")->put("flat", $rule)
            ->put("hash", hlps()->route($rule));

        $trim_keys = $this->get_trim_keys();

        xroute()->push_rule_data($trim_keys);
    }
}