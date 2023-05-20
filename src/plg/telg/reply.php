<?php

namespace lord\plg\telg;

use Illuminate\Support\Collection as collect;
use lord\dbs\cog;
use lord\plg\telg\reply\opts\sole;

class reply
{
    private collect $tmps;

    private collect $datas;

    public function __construct()
    {
        $this->tmps = collect([
            "node" => collect(),
            "maps" => collect()
        ]);

        $this->datas = collect([
            "maps" => collect()
        ]);
    }

    public function node(string $node): self
    {
        $node = "{$node}.orgs.eadg";

        $this->tmps->get("node")->put("flat", $node)
            ->put("hash", hlps()->route($node));

        return $this;
    }

    private function gens_index(object $scopes): string
    {
        return hlps()->route(collect([
            $scopes->rule->hash, $this->tmps->object()->node->hash
        ])->join("."));
    }

    private function gens_call_back_data($scope): string
    {
        return collect()->put("node", $this->gens_index($scope))
            ->put("args", $scope->args)->toJson();
    }

    private function add_reply_to_tmps_maps(array $scopes): void
    {
        collect($scopes)->each(function ($scope) {
            $this->tmps->get("maps")->push([
                "text" => $scope->show->flat,
                "callback_data" => $this->gens_call_back_data($scope),
            ]);
        });
    }

    public function scopes(array|scope ...$scopes): self
    {
        collect()->push($scopes)->flatten()->filter(function ($scope) {
            return $scope instanceof scope;
        })->each(function ($scope) {
            $this->scope($scope);
        });

        return $this;
    }

    public function addrs(scope $scope): self
    {
        $scopes = $scope->sta_gps() ? $scope->get_gps() : $scope->get_tmps();

        collect($scopes)->each(function ($scope) {
            $this->tmps->get("maps")->push([
                "text" => $scope->show->flat,
                "url" => $scope->url->flat,
            ]);
        });

        $maps = $this->tmps->get("maps")->chunkx($scope->get_chunk())->toArray();

        $maps_data = collect($this->datas->get("maps"))->merge($maps);

        $this->datas->forget("maps")->push($maps_data->toArray());

        $this->tmps->put("maps", collect());

        return $this;
    }

    private function make_solo_reply(): sole
    {
        return new sole();
    }

    public function empty_scope(scope $scope): self
    {
        if(! empty($scope->get_tmps())){
            return $this->scope($scope);
        }

        $reply_solo = $this->make_solo_reply()->rule("is.not.working")
            ->show("چیزی یافت نشد");

        return $this->scope($reply_solo)->scope($scope);
    }

    public function scope(scope $scope): self
    {
        $scopes = $scope->get_tmps();

        $this->add_reply_to_tmps_maps($scopes);

        $maps = $this->tmps->get("maps")->chunkx($scope->get_chunk())->toArray();

        $maps_data = collect($this->datas->get("maps"))->merge($maps);

        $check_method = method_exists($scope, "get_page_data");

        $maps_data = $maps_data->when($check_method, function ($collect) use ($scope) {
            $paging = $this->push_paging(
                $scope->get_page_data(), $scope->get_args_page()->toArray()
            );

            return $collect->merge($paging);
        });

        $this->datas->forget("maps")->push($maps_data->toArray());

        $this->tmps->put("maps", collect());

        return $this;
    }

    public function group(array $groups, int $chunk = 2): self
    {
        collect($groups)->each(function ($scope, $node){
            $this->node($node);

            $scopes = $scope->get_tmps();

            $this->add_reply_to_tmps_maps($scopes);
        });

        $maps = $this->tmps->get("maps")->chunkx($chunk)->toArray();

        $maps_data = collect($this->datas->get("maps"))->merge($maps);

        $this->datas->forget("maps")->push($maps_data->toArray());

        $this->tmps->put("maps", collect());

        return $this;
    }

    private function make_sole(): sole
    {
        return new sole();
    }

    public function toggle(bool $toggle_status, scope $scope1, scope $scope2): self
    {
        ($toggle_status ? $this->scope($scope1) : $this->scope($scope2));

        return $this;
    }

    public function admin(scope $scope): self
    {
        $cog_admins = config()->get("telg.admin");

        $dbs_admins = cog::where("name", "admins")->first()->value;

        $dbs_admins = unserialize($dbs_admins);

        $has_admin_chat_id = collect()->push($cog_admins)->push($dbs_admins)
            ->flatten()->unique()->flip()->has(lesa()->chat_id);

        (! $has_admin_chat_id) ?: $this->scope($scope);

        return $this;
    }

    public function where(string $node, scope $scope): self
    {
        $node_data = cog::where("name", $node)->first();

        (! in_array($node_data->value, ["active", "enable"])) ?: $this->scope($scope);

        return $this;
    }

    private function page_next(string $rule, int $page, string $page_show, array $args_page): array
    {
        $page_next = $this->make_sole()->rule("{$rule}.page.next")
            ->show($page_show)->args("page", $page);

        collect($args_page)->each(function ($args) use ($page_next) {
            $args = collect($args)->object();

            $page_next->args($args->key, $args->val);
        });

        return $page_next->get_tmps();
    }

    private function page_prev(string $rule, int $page, string $page_show, array $args_page): array
    {
        $page_prev = $this->make_sole()->rule("{$rule}.page.prev")
            ->show($page_show)->args("page", $page);

        collect($args_page)->each(function ($args) use ($page_prev) {
            $args = collect($args)->object();

            $page_prev->args($args->key, $args->val);
        });

        return $page_prev->get_tmps();
    }

    private function make_page_btn(string $rule, int $page_next, int $page_prev, bool $next_show, bool $prev_show, object $page, array $args_page): array
    {
        return collect()->when($prev_show, function ($scope) use ($rule, $page_prev, $page, $args_page) {
            return $scope->merge($this->page_prev($rule, $page_prev, $page->prev, $args_page));
        })->when($next_show, function ($scope) use ($rule, $page_next, $page, $args_page) {
            return $scope->merge($this->page_next($rule, $page_next, $page->next, $args_page));
        })->toArray();
    }

    private function proc_pageing(object $page): array
    {
        if ($page->offset <= 0) {
            $prev = 0;
            $next = 1;
        } else {
            $prev = ($page->offset - 1);
            $next = ($page->offset + 1);
        }

        $page_plus = ($page->offset + 1);

        if ($page_plus == $page->count) {
            $prev = $prev;
            $next = ($next - 1);
        }

        if ($page_plus > $page->count) {
            $prev = ($page->count - 1);
            $next = $page->count;
        }

        $offset_next = ceil($page->count / $page->take);

        $show_sta = ($page->count > $page->take);

        $next_show_when = ((! $show_sta or $offset_next == $next) ? false : true);

        $prev_show_when = ((! $show_sta or ($prev == 0 and $next == 1)) ? false : true);

        return [
            "page_next" => $next,
            "page_prev" => $prev,
            "next_show" => ($next_show_when and ! $page->hide),
            "prev_show" => ($prev_show_when and ! $page->hide),
        ];
    }

    private function push_paging(object $page, array $args_page): array
    {
        $this->tmps->put("maps", collect());

        # $page_next, $page_prev,$next_show, $prev_show
        extract($this->proc_pageing($page));

        $scopes = $this->make_page_btn(
            $page->rule, $page_next, $page_prev, $next_show, $prev_show, $page, $args_page
        );

        $this->add_reply_to_tmps_maps($scopes);

        return $this->tmps->get("maps")->chunkx($page->line)->toArray();
    }

    public function get_reply(): string
    {
        return collect([
            "inline_keyboard" => $this->datas->flatten(1)
        ])->toJson();
    }
}