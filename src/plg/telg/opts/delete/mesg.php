<?php

namespace lord\plg\telg\opts\delete;

use lord\plg\telg\opts\mguk;

class mesg extends mguk
{
    public function chat_id(int $chat_id = null): self
    {
        return $this->add_data(
            __function__, is_null($chat_id) ? lesa()->chat_id : $chat_id
        );
    }

    public function mesg_id(int $mesg_id = null): self
    {
        return $this->add_data(
            "message_id", is_null($mesg_id) ? lesa()->mesg_id : $mesg_id
        );
    }

    public function exec()
    {
        return telg_reqs()->send_reqs_to_uri(
            "deleteMessage", $this->get_all_data()->toArray()
        )->object();
    }
}