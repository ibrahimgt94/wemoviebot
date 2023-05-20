<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class job extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;

    public function scopeUsername($query)
    {
        $payload = json_decode($this->payload);

        $payload_data = unserialize($payload->data->command);

        $reflect = reflect($payload_data);

        $property1 = $reflect->getProperty("user_id");

        $property1->setAccessible(true);

        $user_id = $property1->getValue($payload_data);

        $property2 = $reflect->getProperty("notice_id");

        $property2->setAccessible(true);

        $notice_id = $property2->getValue($payload_data);

        $user_username = user::where("id", $user_id)->first()->username;

        # $notice_title = notice::where("id", $notice_id)->first()->title;

        return $user_username;
    }
}