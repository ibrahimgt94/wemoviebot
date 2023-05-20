<?php

namespace lord\plg\telg\opts\edit;

use lord\plg\telg\reply;
use stdClass;
use lord\plg\telg\markup;
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

    public function inline_message_id(int $inline_mesg_id = null): self
    {
        return $this->add_data(__function__, $inline_mesg_id);
    }

    public function text(string $text): self
    {
        return $this->add_data(__function__, $text);
    }

    public function parse_mode(string $parse_mode = "HTML"): self
    {
        return $this->add_data(__function__, $parse_mode);
    }

    public function entities(array $entities): self
    {
        return $this->add_data(__function__, $entities);
    }

    public function preview(bool $preview = false): self
    {
        return $this->add_data("disable_web_page_preview", $preview);
    }

    public function markup(reply $reply): self
    {
        return $this->add_data("reply_markup", $reply->get_reply());
    }

    public function exec()
    {
        return telg_reqs()->send_reqs_to_uri(
            "editMessageText", $this->get_all_data()->toArray()
        )->object();
    }
}