<?php

namespace lord\pro;

use Exception;
use Illuminate\Support\ServiceProvider;

class main extends ServiceProvider
{
    public function register()
    {
        $this->macro_object_collect();

        $this->macro_compact_collect();

        $this->macro_call_collect();

        $this->macro_among_collect();

        $this->macro_chunkx_collect();
    }

    private function macro_object_collect(): void
    {
        collect()->macro("object", function () {
            return json_decode(json_encode($this->toArray()));
        });
    }

    private function macro_compact_collect(): void
    {
        collect()->macro("compact", function () {
            return $this->combine(func_get_args())->flip();
        });
    }

    private function macro_call_collect(): void
    {
        collect()->macro("call", function ($name) {
            return (! $this->has($name)) ? (
                die("property '{$name}' not exists")
            ) : (
                reflect($this->get($name))->newInstance()
            );
        });
    }

    private function macro_chunkx_collect()
    {
        collect()->macro("chunkx", function ($size) {
            if ($size <= 0) {
                return new static;
            }

            $chunks = [];

            foreach (array_chunk($this->items, $size, false) as $chunk) {
                $chunks[] = new static($chunk);
            }

            return new static($chunks);
        });
    }

    private function macro_among_collect(): void
    {
        collect()->macro("among", function($among){
            $among = $among->object();

            $among = range($among->start, $among->end, $among->step ?? 1);

            return collect($among);
        });
    }
}