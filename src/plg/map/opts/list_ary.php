<?php

namespace lord\plg\map\opts;

use Illuminate\Support\Collection as collect;
use lord\dbs\tmp;

class list_ary extends edge
{
    public function rule(string $rule): self
    {
        return $this;
    }

    public function type(string $type, string $cell): self
    {
        $this->datas->get("dbs")->put("table", "datas")
            ->put("column", "value")->put("cell", $cell);

        $this->datas->get("type")->put("flat", $type)
            ->put("hash", hlps()->route($type));

        return $this;
    }

    private function generat_rule_flat(): string
    {
        return collect(["query"])->push(
            $this->datas->get("type")->object()->flat
        )->pipe(function ($data) {
            return collect($data)->push(
                lesa()->cals_data_obj->args->query ?? null
            )->join(".");
        });
    }

    private function add_rule_flat_to_datas(string $type_data): void
    {
        collect($this->datas)->get("rule")->put("flat", $type_data)
            ->put("hash", hlps()->route($type_data));
    }

    private function match_type_user(): bool
    {
        return tmp::where("type", $this->datas->get("type")->get("hash"))
            ->where("user_id", lesa()->chat_id)->exists();
    }

    public function __destruct()
    {
        if (! $this->match_type_user()) {
            return;
        }

        $type_data = $this->generat_rule_flat();

        $this->add_rule_flat_to_datas($type_data);

        $trim_keys = $this->get_trim_keys();

        $trim_keys = $this->not_use_prefix($trim_keys);

        xroute()->push_rule_data($trim_keys);
    }
}