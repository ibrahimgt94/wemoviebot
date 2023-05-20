<?php

namespace lord\plg\telg;

use Illuminate\Support\Collection;

abstract class dump
{
    private string $updates = "";

    private $json_updates;

    private $binds;

    private Collection $config;

    protected function booting(): void
    {
        $this->binds = collect([]);

        $this->config = collect(config()->get("telg"));

        $this->updates = $this->load_updates();

        $dump_config = collect(config()->get("dump"));

        $this->json_updates = $this->replace_dump_index($dump_config, $this->updates);

        (! empty($this->json_updates)) ?: (
            exit("get update from telegram server has enable")
        );

        $this->restore_updates($this->json_updates);

        $this->config->get("loadLocalUpdates")
            ?: $this->save_updates();
    }

    private function save_updates(): void
    {
        store()->put("/log/updates", $this->get_updates());
    }

    private function restore_updates(object $updates)
    {
        array_walk($updates, function ($val, $key) {
            is_object($val) ? (
                $this->related($val, $key)
            ) : $this->binds->put($val, $key);
        });
    }

    private function related($val, $key): void
    {
        array_walk($val, function ($one, $two) use ($key) {
            (is_object($one) or is_array($one))
                ? $this->related($one, "{$key}.{$two}")
                : $this->binds->put("{$key}.{$two}", $one);
        });
    }

    protected function get_binds(): array
    {
        return $this->binds->toArray();
    }

    protected function get_bind_key(string $key): mixed
    {
        return $this->binds->get($key);
    }

    private function load_updates()
    {
        return $this->config->get("loadLocalUpdates") ? (
            store()->get("/log/updates")
        ) : file_get_contents("php://input");
    }

    private function replace_dump_index(Collection $dump, string $updates)
    {
        return json_decode(preg_replace($dump->keys()->toArray(), $dump->values()->toArray(), $updates));
    }

    protected function get_updates(): string
    {
        return json_encode($this->json_updates);
    }

    protected function get_json_updates(): object
    {
        return $this->json_updates;
    }
}