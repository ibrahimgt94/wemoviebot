<?php

namespace lord\plg\telg\reply\opts;

use Illuminate\Support\Collection as collect;
use lord\plg\telg\scope;

class list_ary implements scope
{
    protected collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "args_page" => collect(),
            "type" => collect(),
            "not_when" => collect(),
            "list_data" => collect(),
            "cogs" => collect([
                "chunk" => 2,
                "page" => 0,
                "take" => 9,
                "line" => 2
            ]),
            "list" => collect([
                "table" => "lists",
                "column" => "",
                "flag" => false,
            ]),
            "dbs" => collect(),
            "page" => collect([
                "prev" => "صفحه قبلی",
                "next" => "صفحه بعدی",
                "hide" => false,
            ])
        ]);
    }

    public function type(string $type): self
    {
        $this->tmps->get("type")->put("flat", $type);

        return $this;
    }

    public function show(string $vid, string $show): self
    {
        $this->tmps->get("show")->put($vid, ["flat" => $show]);

        return $this;
    }

    public function hide_page(): self
    {
        $this->tmps->get("page")->put("hide", true);

        return $this;
    }

    public function args(string $key, mixed $val): self
    {
        $this->tmps->get("args")->push(compact("key", "val"));

        return $this;
    }

    public function cell(string $cell): self
    {
        $this->tmps->get("dbs")
            ->put("table", "datas")->put("cell", $cell);

        $this->tmps->get("list")
            ->put("table", "lists")->put("column", $cell);

        return $this;
    }

    public function flag_on(): self
    {
        $this->tmps->get("list")->put("flag", true);

        return $this;
    }

    public function page(int $page): self
    {
        $this->tmps->get("cogs")->put("page", $page);

        return $this;
    }

    public function take(int $take): self
    {
        $this->tmps->get("cogs")->put("take", $take);

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

    public function next(string $show): self
    {
        $this->tmps->get("page")->put("next", $show);

        return $this;
    }

    public function prev(string $prev): self
    {
        $this->tmps->get("page")->put("prev", $prev);

        return $this;
    }

    public function not_when($keys)
    {
        $this->tmps->get("not_when")->put("keys", $keys);

        return $this;
    }

    protected function make_sole(): sole
    {
        return new sole();
    }

    protected function gens_rule(object $tmps, mixed $data): string
    {
        return collect(["query"])->push($tmps->type->flat)
            ->push($data)->join(".");
    }

    protected function gens_args(string $val): collect
    {
        if ($this->tmps->get("args")->isNotEmpty()) {
            return collect($this->tmps->get("args"))->push([
                "key" => "query",
                "val" => $val
            ]);
        }

        return collect()->push([
            "key" => "query",
            "val" => $val
        ]);
    }

    public function args_page(string $key, mixed $val): self
    {
        $this->tmps->get("args_page")->push(compact("key", "val"));

        return $this;
    }

    public function get_args_page(): collect
    {
        return $this->tmps->get("args_page");
    }

    protected function gens_reply(collect $dbs_datas, object $tmps): array
    {
        return $dbs_datas->map(function ($val, $key) use ($tmps, $dbs_datas) {
            $user_data = collect($val);

            $list_cell_vals = $this->get_dbs_list($tmps);

            $text_show = ($list_cell_vals->contains($key) and $tmps->list->flag)
                ? "\xF0\x9F\x9A\xA9 ".$user_data->first() : $user_data->first();

            $rule_cell_data = $this->gens_rule($tmps, $key);

            $make_sole = $this->make_sole()->rule($rule_cell_data)->show($text_show);

            $this->gens_args($key)
                ->each(function ($arg) use ($make_sole, $key) {
                    $arg = collect($arg)->object();
                    $make_sole->args($arg->key, $arg->val);
                });

            return $make_sole->get_tmps_two();
        })->toArray();
    }

    public function get_page_data(): object
    {
        return $this->tmps->get("page")->object();
    }

    private function get_dbs_data($tmps): array
    {
        $dbs_gens = dbs()->table($tmps->dbs->table)
            ->where("name", $tmps->dbs->cell)->first()->value;

        $dbs_gens = collect(unserialize($dbs_gens));

        $count = $dbs_gens->count();

        $offset = ($tmps->cogs->page * $tmps->cogs->take);

        $datas = $dbs_gens->chunk($tmps->cogs->take)->get($offset);

        return [$count, $datas];
    }

    public function get_dbs_list($tmps): collect
    {
        $dbs_gens = dbs()->table($tmps->list->table)
            ->where("name", $tmps->list->column)->first()->value;

        return collect(unserialize($dbs_gens));
    }

    private function set_page_data($count, $tmps)
    {
        $this->tmps->get("page")->put("count", $count)
            ->put("line", $tmps->cogs->line)->put("rule", $tmps->type->flat)
            ->put("take", $tmps->cogs->take)->put("offset", $tmps->cogs->page);
    }

    public function get_tmps(): array
    {
        $tmps = $this->tmps->object();

        [$count, $datas] = $this->get_dbs_data($tmps);

        $this->set_page_data($count, $tmps);

        $replys = collect($this->gens_reply($datas, $tmps));

        if(! empty($tmps->not_when->keys)){
            $list_not = $tmps->not_when->keys;

            $list_not = array_combine($list_not, $list_not);

            $replys = $replys->diffKeys($list_not);
        }

        return $replys->toArray();
    }
}