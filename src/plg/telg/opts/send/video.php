<?php

namespace lord\plg\telg\opts\send;

use lord\plg\telg\reply;
use lord\plg\telg\opts\mguk;

class video extends mguk
{
    public function chat_id(int $chat_id = null): self
    {
        return $this->add_data(
            __function__, is_null($chat_id) ? lesa()->chat_id : $chat_id
        );
    }

    public function video(string $file_id): self
    {
        return $this->add_data(__function__, $file_id);
    }

    public function caption(string $text): self
    {
        return $this->add_data(__function__, $text);
    }

    public function caption_entities(string $caption_entities): self
    {
        return $this->add_data(__function__, $caption_entities);
    }

    public function parse_mode(string $parse_mode = "HTML"): self
    {
        return $this->add_data(__function__, $parse_mode);
    }

    public function markup(reply $reply): self
    {
        return $this->add_data("reply_markup", $reply->get_reply());
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

    public function exec(): object
    {
        return parent::handel("sendPhoto");
    }
}