<?php

namespace lord\cos;

use Illuminate\Console\Command;

class mail extends Command
{
    protected $signature = 'mail:send {user}';

    protected $description = 'Send a marketing email to a user';

    public function handle()
    {
        echo "ewfef";
    }
}