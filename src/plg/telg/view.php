<?php

namespace lord\plg\telg;

use Illuminate\Support\Collection as collect;

class view
{
    private collect $tmps;

    private collect $icons;

    public function __construct()
    {
        $this->icons = collect([
            "title" => "\xF0\x9F\x94\x96",
            "text" => "\xF0\x9F\x93\x84",
            "param" => "\xF0\x9F\x91\x89",
            "info" => "",
        ]);

        $this->tmps = collect();
    }

    protected function title(string $title): self
    {
        $title_icon = $this->icons->get("title");

        $this->tmps->push("{$title_icon} {$title}");

        return $this;
    }

    private function gens_text(string $text, string $type = "text"): self
    {
        $text_icon = $this->icons->get($type);

        $this->tmps->push("{$text_icon} {$text}");

        return $this;
    }

    protected function text(string $text): self
    {
        return $this->gens_text($text, "text");
    }

    protected function info(string $info): self
    {
        return $this->gens_text($info, "info");
    }

    protected function param(string $key, mixed $val): self
    {
        $param_icon = $this->icons->get("param");

        $this->tmps->push("{$param_icon} {$key} : {$val}");

        return $this;
    }

    protected function get()
    {
        return $this->tmps->join("\n\n");
    }
}