<?php

namespace lord\plg\telg\opts\set;

use Carbon\Carbon;
use Illuminate\Http\Client\Response;
use stdClass;
use lord\plg\telg\opts\mguk;

class web_hook extends mguk
{
    public function __construct()
    {
        parent::__construct();

        $this->config = collect(config()->get("telg"));
    }

    public function url(string $url = null): self
    {
        return $this->add_data("url",
            is_null($url) ? $this->config->get("webhook") : $url
        );
    }

    public function contact(int $contact = null): self
    {
        return $this->add_data("max_connections",
                is_null($contact) ? $this->config->get("webhook") : $contact
        );
    }

    private function telg_reqs_exec(): stdClass
    {
        $resp_exec = telg_reqs()->send_reqs_to_uri(
            "setWebhook", $this->get_all_data()->toArray()
        )->object();

        store()->put("/log/web_hook", collect([
            "status" => ($resp_exec->ok and $resp_exec->result),
            "date" => Carbon::now(),
            "description" => $resp_exec->description
        ])->toJson());

        return $resp_exec;
    }

    private function resp_not_exec_reqs(): stdClass
    {
        return collect([
            "ok" => false,
            "message" => "set web hook status is off"
        ])->object();
    }

    public function exec(): stdClass
    {
        return $this->config->get("statusSetWebhook") ? (
            $this->telg_reqs_exec()
        ) : $this->resp_not_exec_reqs();
    }
}