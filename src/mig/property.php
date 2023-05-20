<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class property extends migration
{
    public function up(): void
    {
        schema::create('propertys', function (blueprint $table) {
            $table->bigInteger("movie_id")->unsigned()->primary();
            $table->string("director")->default("a:0:{}");
            $table->string("producer")->default("a:0:{}");
            $table->string("writer")->default("a:0:{}");
            $table->string("year")->default("a:0:{}");
            $table->string("filming")->default("a:0:{}");
            $table->string("singer")->default("a:0:{}");
            $table->string("actors")->default("a:0:{}");
            $table->string("duration")->default("a:0:{}");
            $table->string("asong")->default("a:0:{}");

            $table->foreign("movie_id")->references("id")
                ->on("movies")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("propertys");
    }
}