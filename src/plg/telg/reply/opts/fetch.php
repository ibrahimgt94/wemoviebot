<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\reply\opts\query;

class fetch extends query
{
    public function table(string $table): self
    {
        return $this;
    }

    public function when(string $column, mixed $value, string $type = "where"): self
    {
        return $this;
    }

    public function disable(): self
    {
        return $this;
    }

    public function enable(): self
    {
        return $this;
    }

    public function datas(callable $datas): self
    {
        $this->tmps->put("datas", $datas());

        return $this;
    }

    public function get_tmps(): array
    {
        $tmps = $this->tmps->object();

        $dbs_gens = $this->tmps->get("datas");

        $dbs_count = $this->tmps->get("datas")->count();

        $dbs_offset = ($tmps->cogs->page * $tmps->cogs->take);

        $dbs_datas = $dbs_gens->take($tmps->cogs->take)
            ->offset($dbs_offset)->get();

        $this->tmps->get("page")->put("count", $dbs_count)
            ->put("line", $tmps->cogs->line)->put("rule", $tmps->type->flat)
            ->put("take", $tmps->cogs->take)->put("offset", $tmps->cogs->page);

        return $this->gens_reply($dbs_datas, $tmps);
    }
}