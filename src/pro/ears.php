<?php

namespace lord\pro;

use Illuminate\Support\Collection as collect;
use Illuminate\Support\ServiceProvider;
use lord\dbs\tmp;


class ears extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton("ears", function () {
            return new class {
                private $tmp_dbs;

                public function set_chat_id(int $chat_id): self
                {
                    $this->tmp_dbs = tmp::where("user_id", $chat_id);

                    return $this;
                }

                public function get(string $key): mixed
                {
                    $args_data_unserial = unserialize($this->tmp_dbs->first()->args);

                    return collect($args_data_unserial)->get($key);
                }

                public function set(string $key, string $value): void
                {
                    $args_data_unserial = unserialize($this->tmp_dbs->first()->args);

                    $args_data_serial = collect($args_data_unserial)->put($key, $value);

                    $this->save_args($args_data_serial);
                }

                public function all(): array
                {
                    return unserialize($this->tmp_dbs->first()->args);
                }

                public function reset(): void
                {
                    $ears_data = collect($this->all());

                    $except = collect(unserialize($this->tmp_dbs->first()->except));

                    $ears_new_data = $ears_data->intersectByKeys($except->toArray())->toArray();

                    $this->tmp_dbs->update(["args" => serialize($ears_new_data)]);
                }

                public function reset_force(): bool
                {
                    return $this->tmp_dbs->update(["args" => serialize([])]);
                }

                private function save_args(collect $ears): void
                {
                    $this->tmp_dbs->update([
                        "args" => serialize($ears->toArray())
                    ]);
                }

                public function flush(string $name): void
                {
                    $ears = collect($this->all());

                    if($ears->has($name))
                    {
                        $ears->forget($name);

                        $this->save_args($ears);
                    }
                }

                public function except(array $list)
                {
                    $args_data_unserial = unserialize($this->tmp_dbs->first()->except);

                    $args_data_serial = collect($args_data_unserial);

                    collect($list)->each(function ($val) use ($args_data_serial) {
                        if(! $args_data_serial->contains($val)){
                            $args_data_serial->put($val, "");
                        }
                    });

                    $this->tmp_dbs->update([
                        "except" => serialize($args_data_serial->toArray())
                    ]);

                    return $this;
                }

                public function remove_except(array $list)
                {
                    $args_data_unserial = unserialize($this->tmp_dbs->first()->except);

                    $args_data_serial = collect($args_data_unserial);

                    collect($list)->each(function ($val) use ($args_data_serial) {
                        if(! $args_data_serial->contains($val)){
                            $args_data_serial->forget($val);
                        }
                    });

                    $this->tmp_dbs->update([
                        "except" => serialize($args_data_serial->toArray())
                    ]);
                }

                public function set_query(string $name = null): void
                {
                    $args_query = lesa()->cals_data_obj->args->query ?? null;

                    is_null($args_query) ?: $this->set(
                        (is_null($name) ? "query" : $name), $args_query
                    );
                }
            };
        });
    }
}