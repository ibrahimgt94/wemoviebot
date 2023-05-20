<?php

namespace lord\plg\map\opts;

class select extends edge
{
    public function rule(string $rule): self
    {
        $rulex = collect(["select", $rule, "status"])->join(".");

        $this->datas->get("rule")->put("flat", $rulex)
            ->put("hash", hlps()->route($rulex))->put("row", $rule);

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

    private function sta_btn_gens(object $datas)
    {
        $this->datas->forget("targ")->put("targ", collect(
           ["funcs" => $datas->targ->sta]
        ));

        $rulex = collect(["select", $datas->rule->row, "status"])->join(".");

        $this->datas->get("rule")->put("flat", $rulex)
            ->put("hash", hlps()->route($rulex));

        return $this->get_trim_keys();
    }

    private function cap_btn_gens(object $datas)
    {
        $this->datas->forget("targ")->put("targ", collect(
            ["funcs" => $datas->targ->cap]
        ));

        $rulex = collect(["select", $datas->rule->row, "caption"])->join(".");

        $this->datas->get("rule")->put("flat", $rulex)
            ->put("hash", hlps()->route($rulex));

        return $this->get_trim_keys();
    }

    public function __destruct()
    {
        $datas = $this->datas->object();

        is_null($datas->targ->cap) ?: (
            xroute()->push_rule_data($this->cap_btn_gens($datas))
        );

        xroute()->push_rule_data($this->sta_btn_gens($datas));
    }
}