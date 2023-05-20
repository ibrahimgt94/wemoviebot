<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class group_movie extends migration
{
    public function up(): void
    {
        schema::create('group_movie', function (blueprint $table) {
            $table->bigInteger("group_id")->unsigned();
            $table->bigInteger("movie_id")->unsigned();

            $table->foreign("group_id")->references("id")
                ->on("groups")->cascadeOnDelete();

            $table->foreign("movie_id")->references("id")
                ->on("movies")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("group_movie");
    }
}