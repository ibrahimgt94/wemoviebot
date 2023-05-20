<?php

namespace lord\plg\map\opts;

use lord\pro\xdata;

class nums extends edge
{
    public function among(int $start, int $end, int $step = 1): self
    {
        $this->datas->get("nums")->put("step", $step)
            ->put("start", $start)->put("end", $end);

        return $this;
    }

    public function targ(string $targ): self
    {
        return $this;
    }

    public function sta_targ(string $targ): self
    {
        $this->datas->get("targ")->put("sta", $targ);

        return $this;
    }

    public function cap_targ(string $targ): self
    {
        $this->datas->get("targ")->put("cap", $targ);

        return $this;
    }

    private function sta_btn_gens(object $datas): void
    {
        $collect = collect()->among($this->datas->get("nums"));

        $collect->each(function ($number) use ($datas){
            $rule = collect([
                "nums", $datas->rule->flat, $number, "status"
            ])->join(".");

            $this->args("nums", $number);

            collect($this->datas)->get("rule")->put("flat", $rule)
                ->put("hash", hlps()->route($rule));

            $this->datas->forget("targ")->put("targ", collect(
                ["funcs" => $datas->targ->sta]
            ));

            $trim_keys = $this->get_trim_keys();

            xroute()->push_rule_data($trim_keys);
        });
    }

    private function cap_btn_gens(object $datas)
    {
        $this->datas->forget("args")->put("args", collect());

        $this->datas->forget("prefix")->put("prefix", collect());

        $this->datas->forget("targ")->put("targ", collect(
            ["funcs" => $datas->targ->cap]
        ));

        $rulex = collect(["nums", $datas->rule->flat, "caption"])->join(".");

        $this->datas->get("rule")->put("flat", $rulex)
            ->put("hash", hlps()->route($rulex));

        return $this->get_trim_keys();
    }

    public function __destruct()
    {
        $datas = $this->datas->object();

        $this->sta_btn_gens($datas);

        xroute()->push_rule_data($this->cap_btn_gens($datas));
    }
}