<?php

namespace lord\plg\telg;

use lord\dbs\tmp;
use ReflectionClass as reflect_class;
use Illuminate\Support\Collection as collect;
use Illuminate\Database\Eloquent\Builder as builder;

abstract class edge
{
    protected reply $reply;

    private builder $dbs_tmps;

    public function __construct()
    {
        $this->reply = new reply();

        $this->dbs_tmps = tmp::where("user_id", lesa()->chat_id);
    }

    protected function set_type(string $type): void
    {
        $this->dbs_tmps->update(["type" => hlps()->route($type)]);
    }

    protected function reset_type(): void
    {
        $this->dbs_tmps->update(["type" => null]);
    }

    private function get_class_name(): string
    {
        return (new reflect_class($this))->getShortName();
    }

    protected function set_point(string $point): void
    {
        $point = collect([
            hlps()->route("save.{$point}"),
            hlps()->route($this->get_class_name())
        ])->join(".");

        $this->dbs_tmps->update(["point" => hlps()->route($point)]);
    }

    protected function reset_point(): void
    {
        $this->dbs_tmps->update(["point" => hlps()->route("nls")]);
    }

    protected function reset_all(): void
    {
        $this->dbs_tmps->update([
            "type" => null,
            "point" => hlps()->route("nls"),
            "args" => null,
            "mesg" => null,
            "cals" => null,
        ]);
    }

    protected function set_args(array $args): void
    {
        $this->dbs_tmps->update(["args" => serialize($args)]);
    }

    protected function get_args(): collect
    {
        $args_data = unserialize($this->dbs_tmps->first()->args);

        return collect($args_data);
    }

    protected function auto_register_new_user(): void
    {
        \lord\fac\plg\map\auth::check_user_exists();
    }
}