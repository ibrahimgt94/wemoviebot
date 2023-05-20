<?php

print_r(
        (

            '{"uuid":"3233921c-80fc-4cd7-8add-5a836fa5cff4","displayName":"lord\\job\\notice","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"lord\\job\\notice","command":"O:15:\"lord\\job\\notice\":12:{s:24:\"\u0000lord\\job\\notice\u0000user_id\";i:949925585;s:26:\"\u0000lord\\job\\notice\u0000notice_id\";i:7;s:3:\"job\";N;s:10:\"connection\";N;s:5:\"queue\";N;s:15:\"chainConnection\";N;s:10:\"chainQueue\";N;s:19:\"chainCatchCallbacks\";N;s:5:\"delay\";i:10;s:11:\"afterCommit\";N;s:10:\"middleware\";a:0:{}s:7:\"chained\";a:0:{}}"}}'

        )
    );




die("Ewf");
use lord\cos\debug;
use Illuminate\Support\Facades\Artisan;


define('LARAVEL_START', microtime(true));

require __DIR__.'/../../vendor/autoload.php';

$app = new \Illuminate\Foundation\Application(
    dirname(__DIR__)
);

$app->singleton(
    \Illuminate\Contracts\Console\Kernel::class,
    \lord\cos\kernel::class
);

$app->singleton(
    \Illuminate\Contracts\Debug\ExceptionHandler::class,
    debug::class
);

$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);

$kernel->registerCommand(
    app()->make(\Illuminate\Foundation\Console\UpCommand::class)
);

app()->instance("config", new \Illuminate\Config\Repository());

config()->set("database", [
    "driver" => "mysql",
    "host" => "localhost",
    "database" => "paranopg_ghs",
    "username" => "paranopg_ghs",
    "password" => "+I&iVj46(vM9",
    "charset" => "utf8mb4",
    "collation" => "utf8mb4_unicode_ci",
    "prefix" => "",
    "engine" => "InnoDB",
]);

config()->set("queue", [
    'driver' => 'database',
    'table' => 'jobs',
    'queue' => 'default',
    'retry_after' => 90,
    'after_commit' => false,
    'default' => 'database',
]);

app()->register(\Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class);
app()->register(\Illuminate\Queue\QueueServiceProvider::class);
app()->register(\Illuminate\Cache\CacheServiceProvider::class);
app()->register(\Illuminate\Database\DatabaseServiceProvider::class);
app()->register(\Illuminate\Bus\BusServiceProvider::class);


//$app->bind(\Illuminate\Contracts\Bus\Dispatcher::class);


//dd(app()->make(\Illuminate\Queue\CallQueuedHandler::class));

$kernel->registerCommand($app->make("command.queue.work"));

$kernel->registerCommand($app->make("command.queue.listen"));

$status = $kernel->handle(
    $input = new \Symfony\Component\Console\Input\ArgvInput,
    new \Symfony\Component\Console\Output\ConsoleOutput
);

$kernel->terminate($input, $status);

exit($status);

