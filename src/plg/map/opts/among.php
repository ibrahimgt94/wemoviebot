<?php

namespace lord\plg\map\opts;

class among extends edge
{
    public function among(int $start, int $end, int $step = 1): self
    {
        $this->datas->get("among")->put("step", $step)
            ->put("start", $start)->put("end", $end);

        return $this;
    }

    public function __destruct()
    {
        $rule_data = $this->datas->get("rule")->object();

        collect()->among($this->datas->get("among"))
            ->each(function ($number) use ($rule_data) {
                $rule = collect(["among", $rule_data->flat, $number])->join(".");

                $this->args("among", $number);

                collect($this->datas)->get("rule")->put("flat", $rule)
                    ->put("hash", hlps()->route($rule));

                $trim_keys = $this->get_trim_keys();

                xroute()->push_rule_data($trim_keys);
            });
    }
}