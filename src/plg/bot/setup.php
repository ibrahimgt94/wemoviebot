<?php

namespace lord\plg\bot;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\DatabaseServiceProvider;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Facades\DB;
use lord\dbs\cog;
use lord\plg\map\map;
use Illuminate\Filesystem\FilesystemServiceProvider;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Config\Repository;
use Illuminate\Support\Facades\Schema as schema;

class setup
{
    public function handel(): void
    {
        app()->instance("config", new Repository());

        app()->register(FilesystemServiceProvider::class);

        $this->loadConfigs();

        $this->regisSP();

        $this->regisCF();

        $this->loadConfigs();

        $this->setDatabaseConnection();

        (! config("telg.gensDumpDatabse")) ?: (
            $this->gens_dump_dbs()
        );

        app()->setLocale("fa");

        $this->loadTelgMap();
    }

    private function regisCF(): void
    {
        $hlp_path = Storage::disk("local")->path("plg/bot/hlp.php");

        include_once $hlp_path;
    }

    private function regisSP(): void
    {
        $listSP = config()->get("pro");

        array_walk($listSP, function ($sp){
            app()->register($sp);
        });
    }

    private function setDatabaseConnection(): void
    {
        app()->register(DatabaseServiceProvider::class);

        Model::setConnectionResolver(app("db"));
    }

    private function loadConfigs()
    {
        $configs = $this->getConfigs();

        array_walk($configs, function ($fileInfo) {
            config()->set(
                $fileInfo->getBasename(".php"),
                include $fileInfo->getPathname()
            );
        });
    }

    private function getConfigs(): array
    {
        return File::files(
            app()->basePath("cog")
        );
    }

    private function loadTelgMap(): void
    {
        app()->make(map::class)->booting();
    }

    private function gens_dump_dbs(): void
    {
        schema::hasTable('cogs') ?: (
            (new \lord\mig\cog)->up()
        );
        
        $cogs_dbs = dbs()->table("cogs");
        
        $cogs_dbs->where("name", "admins")->exists() ?: (
            $cogs_dbs->insert([
                "name" => "admins",
                "value" => serialize([config("telg.supportAdmin")]),    
            ])
        );

        schema::hasTable('users') ?: (
            (new \lord\mig\user)->up()
        );
        
        schema::hasTable('tmps') ?: (
            (new \lord\mig\tmp)->up()
        );

        schema::hasTable('movies') ?: (
            (new \lord\mig\movie())->up()
        );

        schema::hasTable('propertys') ?: (
            (new \lord\mig\property())->up()
        );

        schema::hasTable('datas') ?: (
            (new \lord\mig\data())->up()
        );

        schema::hasTable('groups') ?: (
            (new \lord\mig\group())->up()
        );

        schema::hasTable('group_movie') ?: (
            (new \lord\mig\group_movie())->up()
        );

        schema::hasTable('downs') ?: (
            (new \lord\mig\down())->up()
        );

        schema::hasTable('down_movie') ?: (
            (new \lord\mig\down_movie())->up()
        );

        schema::hasTable('notices') ?: (
            (new \lord\mig\notice())->up()
        );

        schema::hasTable('lists') ?: (
            (new \lord\mig\listx())->up()
        );

        schema::hasTable('jobs') ?: (
            (new \lord\mig\jobs())->up()
        );

        schema::hasTable('fails') ?: (
            (new \lord\mig\fail())->up()
        );
    }
}