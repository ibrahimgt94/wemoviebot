<?php

if (! function_exists('lesa')) {
    /**
     * Load update get from api telegram
     *
     * @return \lord\plg\telg\lesa
     */
    function lesa()
    {
        return app()->make(\lord\plg\telg\lesa::class);
    }
}

if (! function_exists('telg')) {
    /**
     * Load update get from api telegram
     *
     * @return \lord\plg\telg\telg
     */
    function telg()
    {
        return app()->make(\lord\plg\telg\telg::class);
    }
}

if (! function_exists('send_mesg')) {
    /**
     * func sendMessage telegram api
     *
     * @return \lord\plg\telg\opts\send\mesg
     */
    function send_mesg()
    {
        return app()->make(\lord\plg\telg\opts\send\mesg::class);
    }
}

if (! function_exists('telg_reqs')) {
    /**
     * func sendMessage telegram api
     *
     * @return \lord\plg\telg\reqs
     */
    function telg_reqs()
    {
        return app()->make(\lord\plg\telg\reqs::class);
    }
}

if (! function_exists('store')) {
    /**
     * file system class
     *
     * @return \Illuminate\Support\Facades\Storage
     */
    function store()
    {
        return app()->make("filesystem");
    }
}

if (! function_exists('xroute')) {
    /**
     * robat telegram router
     *
     * @return \lord\plg\map\xroute
     */
    function xroute()
    {
        return app()->make(\lord\plg\map\xroute::class);
    }
}

if (! function_exists('dbs')) {
    /**
     * robat telegram router
     *
     * @return \Illuminate\Database\MySqlConnection
     */
    function dbs()
    {
        return \Illuminate\Support\Facades\DB::connection();
    }
}

if (! function_exists('str')) {
    /**
     * robat telegram router
     *
     * @return \Illuminate\Support\Str
     */
    function str()
    {
        return app()->make("str");
    }
}

if (! function_exists('reflect')) {
    /**
     * robat telegram router
     *
     * @return \ReflectionClass
     */
    function reflect(mixed $class)
    {
        return new ReflectionClass($class);
    }
}

if (! function_exists('xdata')) {
    /**
     * robat telegram router
     *
     * @return \Illuminate\Support\Collection
     */
    function xdata()
    {
        return app()->make("xdata");
    }
}

if (! function_exists('hlps')) {
    /**
     * robat telegram router
     *
     * @return \lord\plg\map\hlps
     */
    function hlps()
    {
        return app()->make("hlps");
    }
}

if (! function_exists('rdata')) {
    /**
     * robat telegram router
     *
     * @return \Illuminate\Support\Collection
     */
    function rdata()
    {
        return app()->make("rdata");
    }
}

if (! function_exists('ears')) {
    /**
     * set serial data to table tmp columan args
     *
     *
     */
    function ears()
    {
        return app()->make("ears")->set_chat_id((lesa()->chat_id));
    }
}

if (! function_exists('erinfo')) {
    /**
     * set serial data to table tmp columan args
     *
     *
     */
    function erinfo($data)
    {
        store()->put("/pub/erinfo", json_encode($data));
    }
}

if (! function_exists('artisan')) {
    /**
     * set serial data to table tmp columan args
     *
     *
     */
    function artisan(): \Illuminate\Console\Application
    {

    }
}