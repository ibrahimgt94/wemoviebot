<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class movie extends migration
{
    public function up(): void
    {
        schema::create('movies', function (blueprint $table) {
            $table->id();
            $table->string("title", 50);
            $table->string("image", 255);
            $table->string("summary", 255);
            $table->boolean("is_draft")->default(false);
            $table->boolean("status")->default(true);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("movies");
    }
}