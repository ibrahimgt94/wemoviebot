<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class notice extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;

    public function getPayload()
    {
        return "salama";
    }

    public static function get_payload_data($payload_data, array $keys)
    {
        $reflect = reflect($payload_data);

        $data_reqs = collect();

        collect($keys)->each(function ($key) use ($reflect, $payload_data, $data_reqs) {

            if(! $reflect->hasProperty($key)){
                return null;
            }

            $property2 = $reflect->getProperty($key);

            $property2->setAccessible(true);

            $value = $property2->getValue($payload_data);

            $data_reqs->put($key, $value);
        });

        return $data_reqs->filter();
    }
}