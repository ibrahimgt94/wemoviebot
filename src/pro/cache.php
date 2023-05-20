<?php

namespace lord\pro;

use Illuminate\Cache\CacheManager;
use Illuminate\Cache\FileStore;
use Illuminate\Cache\Repository;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class cache extends ServiceProvider
{
    public function register()
    {
        cache()->macro("put_many", function ($key, $val, $ttl = 60){
            cache()->has($key) ?: (
                cache()->put($key, [], $ttl)
            );

            $cache_data = cache()->get($key);

            in_array($val, $cache_data) ?: (
                array_push($cache_data, $val)
            );

            cache()->put($key, $cache_data, $ttl);
        });

        cache()->macro("has_many", function ($key, $val){
            return in_array($val,
                (cache()->has($key) ? cache()->get($key) : [])
            );
        });
    }
}