<?php

namespace lord\plg\telg;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class reqs
{
    private $config;

    private $urapi = "https://api.telegram.org";

    public function __construct()
    {
        $this->config = collect(config()->get("telg"));
    }

    private function get_reqs_uri(string $token, string $func): string
    {
        return "{$this->urapi}/bot{$token}/{$func}?";
    }

    private function get_reqs_file(string $token, string $path): string
    {
        return "{$this->urapi}/file/bot{$token}/{$path}";
    }

    private function get_func_name(string $func_name): string
    {
        return str_replace(".", "", $func_name);
    }

    public function reqs_file_down(string $path)
    {
        return Http::get($this->get_reqs_file(
            $this->config->get("token"), $path
        ))->getBody();
    }

    public function send_reqs_to_uri(string $func_name, array $params = []): Response
    {
        return Http::post($this->get_reqs_uri(
            $this->config->get("token"), $this->get_func_name($func_name)
        ), $params);
    }
}