<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class movie_property extends migration
{
    public function up(): void
    {
        schema::create('movie_property', function (blueprint $table) {
            $table->bigInteger("movie_id")->unsigned();
            $table->bigInteger("property_id")->unsigned();

            $table->foreign("movie_id")->references("id")
                ->on("movies")->cascadeOnDelete();

            $table->foreign("property_id")->references("id")
                ->on("propertys")->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("movie_property");
    }
}