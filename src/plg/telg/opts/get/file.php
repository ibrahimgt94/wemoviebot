<?php

namespace lord\plg\telg\opts\get;

use Illuminate\Support\Facades\Storage;
use lord\plg\telg\opts\mguk;
use lord\plg\telg\reqs;

class file extends mguk
{
    public function file_id(string $file_id): self
    {
        return $this->add_data(__function__, $file_id);
    }

    public function down_fild_id(string $file_id): mixed
    {
        $file_data = $this->file_id($file_id)->exec();

        $image = $this->get_image_body($file_data);

        $file_name_hash = strtolower(
            trim(crypt($file_id, str_shuffle(
                "ecrk6qlg71tmlus3baaai1ujebcjsoud7y2vgtfvqsaqadagadeaadkgq"
            )), ".")
        );

        $site_uri = config()->get("app.site");

        $file_name = "pub/asset/image/{$file_name_hash}.png";

        $file_name_uri = "asset/image/{$file_name_hash}.png";

        return Storage::disk("local")->put($file_name, $image) ? (
            "{$site_uri}/{$file_name_uri}"
        ) : false;
    }

    private function get_image_body($file_data)
    {
        return app()->make(reqs::class)
            ->reqs_file_down($file_data->result->file_path);
    }

    public function exec(): object
    {
        return parent::handel("getFile");
    }
}