<?php

namespace lord\plg\telg\reply\opts;

use lord\dbs\job;
use lord\dbs\user;
use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;
use Illuminate\Database\Eloquent\Builder as builder;

class query implements scope
{
    protected collect $tmps;

    private string $dbs_space = "\\lord\\dbs";

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "rule" => collect(),
            "args" => collect(),
            "args_page" => collect(),
            "type" => collect(),
            "cogs" => collect([
                "chunk" => 2,
                "page" => 0,
                "take" => 9,
                "line" => 2
            ]),
            "chunk" => 2,
            "list" => collect([
                "table" => "list",
                "column" => "",
                "type" => "one",
                "when" => null,
                "cell" => "id"
            ]),
            "dbs" => collect(),
            "where" => collect(),
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

    public function args_page(string $key, mixed $val): self
    {
        $this->tmps->get("args_page")->push(compact("key", "val"));

        return $this;
    }

    public function get_args_page(): collect
    {
        return $this->tmps->get("args_page");
    }

    public function table(string $table): self
    {
        $this->tmps->get("dbs")
            ->put("table", "{$this->dbs_space}\\{$table}");

        return $this;
    }

    public function cell(string $cell, string $show = null, $is_scope = false): self
    {
        $this->tmps->get("dbs")->put("cell", $cell)
            ->put("show", $show ?? $cell)->put("is_scope", $is_scope);

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

    private function where(string $column, mixed $value, string $type = "where"): self
    {
        $this->tmps->get("where")->push(collect([
            "type" => $type,
            "column" => $column,
            "value" => $value,
        ])->object());

        return $this;
    }

    public function when(string $column, mixed $value, string $type = "where"): self
    {
        return $this->where($column, $value, $type);
    }

    public function disable(): self
    {
        return $this->where("status", false);
    }

    public function enable(): self
    {
        return $this->where("status", true);
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

    protected function make_sole(): sole
    {
        return new sole();
    }

    protected function gens_rule(object $tmps, mixed $data): string
    {
        return collect(["query"])->push($tmps->type->flat)
            ->push($data)->join(".");
    }

    protected function dbs_wheres(builder $dbs): builder
    {
        $this->tmps->get("where")->each(function ($data) use ($dbs) {
            ($data->type != "where") ?: (
                $dbs->where($data->column, $data->value)
            );

            ($data->type != "where_in") ?: (
                $dbs->whereIn($data->column, $data->value)
            );
        });

        return $dbs;
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

    protected function gens_reply(collect $dbs_datas, object $tmps): array
    {
        return $dbs_datas->map(function ($user) use ($tmps) {
            $user_data = collect($user);

            $rule_cell_data = $this->gens_rule(
                $tmps, $user_data->get($tmps->dbs->cell)
            );

            $make_sole = $this->make_sole()->rule($rule_cell_data)->show(
                $tmps->dbs->is_scope ? (
                    $user->{$tmps->dbs->show}()
                ) : $user_data->get($tmps->dbs->show)
            );

            $this->gens_args($user_data->get($tmps->dbs->cell))
                ->each(function ($arg) use ($make_sole) {
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

    private function get_table_instance($tmps)
    {
        $table = $tmps->dbs->table;

        $table_dbs = $table::newModelInstance();

        $reflect = reflect($table_dbs);

        $property = $reflect->getProperty("fillable");

        $property->setAccessible(true);

        $fillable = $property->getValue($table_dbs);

        return $table::select($fillable);
    }

    private function get_dbs_data($tmps): array
    {
        $dbs_gens = $this->get_table_instance($tmps);

        $dbs_gens = $this->dbs_wheres($dbs_gens);

        $dbs_gens_copy = clone $dbs_gens;

        $dbs_count = $dbs_gens_copy->count();

        $dbs_offset = ($tmps->cogs->page * $tmps->cogs->take);

        $dbs_datas = $dbs_gens->take($tmps->cogs->take)
            ->offset($dbs_offset)->get();

        return [$dbs_count, $dbs_datas];
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

        return $this->gens_reply($datas, $tmps);
    }
}