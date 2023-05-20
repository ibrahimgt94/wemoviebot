<?php

namespace lord\job;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use lord\dbs\user as user_dbs;
use lord\dbs\notice as notice_dbs;

class notice implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $user_id;

    private int $notice_id;

    public function __construct(int $user_id, int $notice_id)
    {
        $this->user_id = $user_id;

        $this->notice_id = $notice_id;
    }

    public function handle()
    {
        $telg_user_id = user_dbs::where("id", $this->user_id)->first()->id;

        $notice_body = notice_dbs::where("id", $this->notice_id)->first()->body;

        telg()->send_mesg->chat_id($telg_user_id)->text($notice_body)->exec();
    }
}