<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class down_movie extends migration
{
    public function up(): void
    {
        schema::create('down_movie', function (blueprint $table) {
            $table->bigInteger("down_id")->unsigned();
            $table->bigInteger("movie_id")->unsigned();

            $table->foreign("down_id")->references("id")
                ->on("downs")->cascadeOnDelete();

            $table->foreign("movie_id")->references("id")
                ->on("movies")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("down_movie");
    }
}