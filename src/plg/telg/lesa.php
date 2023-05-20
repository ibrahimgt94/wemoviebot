<?php

namespace lord\plg\telg;

use lord\plg\telg\dump;
use Illuminate\Support\Collection as collect;

/**
 * @property int $chat_id
 * @property int $from_id
 * @property int $mesg_id
 * @property int $cals_id
 * @property string $cals_data
 * @property string $mesg_text
 * @property string $mesg_text_hash
 * @property string $mesg_text_param
 * @property string $mesg_text_slice
 * @property int $line_id
 * @property string $line_query
 * @property string $chat_fname
 * @property string $chat_lname
 * @property string $chat_user
 * @property string $cals_data_obj
 * @property string $cals_data_ary
 * @property string $get_type
 * @property object $ents_obj
 * @property bool has_ents_cmd
 * @property array photo_ary
 */
class lesa extends dump
{
    public function booting(): void
    {
        parent::booting();
    }

    public function __get(string $key): mixed
    {
        $json_update = $this->get_json_updates();

        return method_exists($this, $key) ? (
            call_user_func([$this, $key], $json_update)
        ) : "nls";
    }

    private function chat_id($json): int
    {
        return $json->cals->from->id ?? (
            $json->mesg->from->id
        ) ?? $json->line->from->id;
    }

    private function from_id($json): int
    {
        return $json->cals->from->id ?? (
            $json->mesg->from->id
        ) ?? $json->line->from->id;
    }

    private function mesg_id($json): int
    {
        return $json->cals->mesg->id ?? (
            $json->mesg->id
        );
    }

    private function cals_id($json): mixed
    {
        return $json->cals->id ?? null;
    }

    private function cals_data($json): string
    {
        return $json->cals->data ?? "";
    }

    private function cals_data_ary($json): array
    {
        return json_decode($json->cals->data ?? "", true) ?? [];
    }

    private function mesg_text($json): string
    {
        return $json->mesg->text;
    }

    private function mesg_text_hash($json): string
    {
        return hlps()->route($this->mesg_text_slice($json)->first());
    }

    private function mesg_text_param($json): string
    {
        return $this->mesg_text_slice($json)->last();
    }

    private function mesg_text_slice($json): collect
    {
        return str()->of($json->mesg->text ?? "")
            ->explode(" ")->pad(2, 0);
    }

    private function line_id($json): int
    {
        return $json->line->id;
    }

    private function line_query($json): string
    {
        return $json->line->query;
    }

    private function chat_fname($json): string
    {
        return $json->cals->from->fname ?? (
            $json->mesg->chat->fname
        ) ?? "";
    }

    private function chat_lname($json): string
    {
        return $json->cals->from->lname ?? (
            $json->mesg->chat->lname
        ) ?? "";
    }

    private function has_key(string $key): bool
    {
        return collect($this->get_binds())->has($key);
    }

    private function get_type(): string
    {
        return $this->has_key("mesg.id") ? "base" : (
            $this->has_key("cals.id") ? "glass" : (
                $this->has_key("line.id") ? "line" : "nls"
            )
        );
    }
    
    private function chat_user($json): string
    {
        return $json->cals->from->username ?? (
            $json->mesg->chat->username
        ) ?? "";
    }

    private function cals_data_obj(): object
    {
        $cals_data = collect($this->cals_data_ary);

        return (! $cals_data->isEmpty()) ? $cals_data->object() : (new \stdClass());
    }

    private function ents_ary($json): array
    {
        return collect($json->mesg->ents)->object();
    }

    private function has_ents_cmd($josn): bool
    {
        $get_ents_types = array_column($this->ents_ary,"type");

        return in_array("bot_command", $get_ents_types);
    }

    public function photo_ary($json): array
    {
//        erinfo($json);
        return $json->mesg->photo;
    }
}