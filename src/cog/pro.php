<?php

use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Validation\ValidationServiceProvider;
use Illuminate\Foundation\Providers\ArtisanServiceProvider;
use Illuminate\Queue\QueueServiceProvider;
use Illuminate\Bus\BusServiceProvider;
use Illuminate\Cache\CacheServiceProvider;

return [

    CacheServiceProvider::class,
    BusServiceProvider::class,
    QueueServiceProvider::class,
    ArtisanServiceProvider::class,
    ValidationServiceProvider::class,
    TranslationServiceProvider::class,
    \lord\pro\main::class,
    \lord\pro\lesa::class,
    \lord\pro\cache::class,
    \lord\pro\str::class,
    \lord\pro\xdata::class,
    \lord\pro\hlps::class,
    \lord\pro\rdata::class,
    \lord\pro\ears::class,
    \lord\pro\queue::class,
    Anetwork\Validation\PersianValidationServiceProvider::class,
    TranslationServiceProvider::class

];