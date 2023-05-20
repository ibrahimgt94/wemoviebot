<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class tmp extends model
{
    protected $fillable = [
        "user_id", "point", "mesg", "cals", "type", "args"
    ];

    public $timestamps = false;

    public function add_args(string $key, mixed $value): void
    {
        $args_data_unserial = unserialize($this->tmp_dbs->first()->args);

        $args_data_serial = collect($args_data_unserial)->put($key, $value)->toArray();

        $this->tmp_dbs->update(["args", $args_data_serial]);
    }

    public function get_args(string $key): mixed
    {
        $args_data_unserial = unserialize($this->tmp_dbs->first()->args);

        return collect($args_data_unserial)->get($key);
    }
}