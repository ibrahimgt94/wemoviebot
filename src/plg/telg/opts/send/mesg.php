<?php

namespace lord\plg\telg\opts\send;

use lord\plg\telg\reply;
use lord\plg\telg\view;
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

    public function notification(bool $notification = true): self
    {
        return $this->add_data("disable_notification", $notification);
    }

    public function protect(bool $protect = false): self
    {
        return $this->add_data("protect_content", $protect);
    }

    public function reply_to_mesg(int $mesg_id): self
    {
        return $this->add_data("reply_to_message_id", $mesg_id);
    }

    public function markup(reply $reply): self
    {
        return $this->add_data("reply_markup", $reply->get_reply());
    }

    public function exec()
    {
        return parent::handel("sendMessage");
    }
}