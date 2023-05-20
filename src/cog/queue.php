<?php

return [
    'driver' => 'database',
    'table' => 'jobs',
    'queue' => 'default',
    'retry_after' => 90,
    'after_commit' => false,
    'timeout' => 180,

    "default" => "database",
    'connections' => [
        'database' =>  [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
            'timeout' => 180,
        ]
    ],
    'failed' => [
        'driver' => 'database-uuid',
        'database' => 'mysql',
        'table' => 'fails',
    ],
];