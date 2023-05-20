<?php

namespace lord\plg\map;

use lord\dbs\tmp;
use lord\dbs\user;

class auth
{
    private int $ttl = 60;

    private int $subset_coin_gift = 2;

    private function check_user_exists_cache(): bool
    {
        return cache()->has_many("users", lesa()->chat_id);
    }

    private function check_user_exists_dbs(): bool
    {
        $has_user = user::where("id", lesa()->chat_id)->exists();

        (! $has_user) ?: $this->user_id_put_cache($this->ttl);

        return $has_user;
    }

    public function regis_new_user(): void
    {
        if (! $this->check_user_exists_cache()) {
            $this->check_user_exists_dbs() ?: (
                (! $this->exec_create_user()) ?: $this->user_id_put_cache($this->ttl)
            );
        }
    }

    private function user_id_put_cache(int $ttl): void
    {
        cache()->put_many("users", lesa()->chat_id, $ttl);
    }

    private function exec_create_user(): bool
    {
        dbs()->beginTransaction();

        $status_register = $this->status_register_new_user();

        $status_register ? dbs()->commit() : dbs()->rollBack();

        $status_register ?: (
            $this->save_error_create_user()
        );

        return $status_register;
    }

    private function save_error_create_user(): bool
    {
        store()->put("/log/create_user", collect([
            "user_id" => lesa()->chat_id,
            "message" => "create user is error"
        ])->toJson());

        return false;
    }

    private function status_register_new_user(): bool
    {
        return ($this->create_new_user() and $this->create_new_tmp());
    }

    private function create_new_user(): bool
    {
        $user_info = collect([
            "id" => lesa()->chat_id,
            "fname" => lesa()->chat_fname,
            "lname" => lesa()->chat_lname,
            "username" => lesa()->chat_user,
        ])->merge($this->parent_info())->toArray();

        return user::create($user_info)->exists();
    }

    private function parent_info(): array
    {
        return collect()->when($this->check_mpa_parent(), function ($collect) {
            $parent_id = lesa()->mesg_text_param;
            $user_dbs = user::where("id", $parent_id);
            $user_dbs->increment("subset");
            $user_dbs->increment("coin", $this->subset_coin_gift);
            return $collect->put("parent", $parent_id);
        })->toArray();
    }

    private function parent_has_valid(int $parent_id): bool
    {
        return (is_integer($parent_id) and strlen($parent_id) >= 7);
    }

    private function check_mpa_parent(): bool
    {
        if(lesa()->get_type != "base"){
            return false;
        }

        $parent_id = lesa()->mesg_text_param;

        return $this->parent_has_valid($parent_id) ? (
            $this->check_parent($parent_id)
        ) : false;
    }

    private function check_parent(int $parent_id): bool
    {
        $has_parent = user::where("id", $parent_id)->exists();

        $not_equal_chatid_and_parent = (lesa()->chat_id != $parent_id);

        return ($not_equal_chatid_and_parent and $has_parent);
    }

    private function create_new_tmp(): bool
    {
        return tmp::create([
            "user_id" => lesa()->chat_id,
        ])->exists();
    }
}