<?php

namespace lord\plg\telg\opts;


use Illuminate\Support\Collection as collect;

abstract class mguk
{
    private $datas;

    public function __construct()
    {
        $this->datas = collect([]);
    }

    protected function add_data(string $key, mixed $data): self
    {
        $this->datas->put($key, $data);

        return $this;
    }

    protected function get_data(string $key): mixed
    {
        return (! $this->datas->has($key)) ?: $this->datas->get($key);
    }

    protected function get_all_data(): collect
    {
        return $this->datas;
    }

    protected function handel(string $func_name): object
    {
        $get_all_data = $this->get_all_data()->toArray();

        return telg_reqs()->send_reqs_to_uri($func_name, $get_all_data)->object();
    }
}