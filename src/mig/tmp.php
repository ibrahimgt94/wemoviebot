<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class tmp extends migration
{
    public function up(): void
    {
        schema::create('tmps', function (blueprint $table) {
            $table->bigInteger("user_id")->unsigned()->primary();
            $table->string("point", 12)->default("0ec3955c3");
            $table->string("mesg", 30)->nullable();
            $table->string("cals", 30)->nullable();
            $table->string("type", 12)->nullable();
            $table->longText("args")->default("a:0:{}");
            $table->longText("except")->default("a:0:{}");

            $table->foreign("user_id")->references("id")
                ->on("users")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("tmps");
    }
}