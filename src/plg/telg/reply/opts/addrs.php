<?php

namespace lord\plg\telg\reply\opts;

use lord\plg\telg\scope;
use Illuminate\Support\Collection as collect;

class addrs implements scope
{
    private collect $tmps;

    public function __construct()
    {
        $this->tmps = collect([
            "show" => collect(),
            "url" => collect(),
            "args" => collect(),
            "chunk" => 1,
            "gps" => false,
            "cdata" => collect(),
        ]);
    }

    public function show(string $show): self
    {
        $this->tmps->get("show")->put("flat", $show);

        return $this;
    }

    public function url(string $url): self
    {
        $this->tmps->get("url")->put("flat", $url);

        return $this;
    }

    public function args(string $key, mixed $val): self
    {
        $this->tmps->get("args")->push(compact("key", "val"));

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

    public function set_gps($urls)
    {
        $this->tmps->put("gps", true)
            ->put("cdata", $urls);
    }

    public function sta_gps(): bool
    {
        return $this->tmps->get("gps");
    }

    public function get_gps()
    {
        return $this->tmps->get("cdata")->map(function ($url){
            $tmps = collect($url)->first();

            $args_data = array_column($tmps->args, "val", "key");

            $args_query_data = http_build_query($args_data);

            $url_args_data = str()->of($tmps->url->flat)
                ->append("?")->append($args_query_data);

            return (new addrs())->url($url_args_data)->show($tmps->show->flat)->get_tmps()[0];
        });
    }

    public function get_tmps(): array
    {
        $args_data = $this->tmps->get("args")->toArray();

        $args_data = array_column($args_data, "val", "key");

        $args_query_data = http_build_query($args_data);

        $url_data = $this->tmps->get("url")->object();

        $url_args_data = str()->of($url_data->flat)
            ->append("?")->append($args_query_data);

        $this->tmps->get("url")->put("flat", $url_args_data);

        return [$this->tmps->object()];
    }
}