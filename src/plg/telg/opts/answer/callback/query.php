<?php

namespace lord\plg\telg\opts\answer\callback;

use lord\plg\telg\opts\mguk;

class query extends mguk
{
    public function __construct()
    {
        parent::__construct();

        $this->add_data("callback_query_id", lesa()->cals_id);
    }

    public function callback_query_id(string $query_id = null): self
    {
        return $this->add_data(__function__, $query_id);
    }

    public function text(string $text): self
    {
        return $this->add_data(__function__, $text);
    }

    public function show_alert(bool $show = false): self
    {
        return $this->add_data(__function__, $show);
    }

    public function url(string $url): self
    {
        return $this->add_data(__function__, $url);
    }

    public function cache_time(int $time = 0): self
    {
        return $this->add_data(__function__, $time);
    }

    public function exec(): object
    {
        return parent::handel("answerCallbackQuery");
    }
}