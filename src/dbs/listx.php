<?php

namespace lord\dbs;

use Illuminate\Database\Eloquent\Model as model;

class listx extends model
{
    protected $fillable = ["*"];

    public $timestamps = false;

    protected $table = "lists";

    public function scopePuting($query, string $name, array $data, $reset = false)
    {
        $hand = $query->where("name", $name);

        $insert = function ($name, $data){
            $this->insert([
                "name" => $name, "value" => serialize($data)
            ]);
        };

        if($hand->exists())
        {
            if($reset == false)
            {
                $this->sync_vals($hand, $data);
            }else{
                $hand->delete();

                $insert($name, $data);
            }
        }else{
            $insert($name, $data);
        }
    }

    private function sync_vals($hand, $data)
    {
        $vals = unserialize($hand->first()->value);

        $data_vals = array_merge($vals, $data);

        $hand->update(["value" => serialize($data_vals)]);
    }

    public function scopeGetting($query, string $name, string $key)
    {
        $hand = $query->where("name", $name);

        if($hand->exists())
        {
            $vals = collect(unserialize($hand->first()->value));

            return ($vals->has($key)) ? $vals->get($key) : null;
        }else{
            return null;
        }
    }

    public function scopeAlling($query, string $name)
    {
        $hand = $query->where("name", $name);

        if($hand->exists())
        {
            return collect(unserialize($hand->first()->value))->toArray();
        }else{
            return null;
        }
    }
}