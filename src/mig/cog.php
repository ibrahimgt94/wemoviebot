<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class cog extends migration
{
    public function up(): void
    {
        schema::create('cogs', function (blueprint $table) {
            $table->string("name", 90)->primary();
            $table->string("name_fa", 90);
            $table->string("value")->nullable();
        });
    }

    public function down(): void
    {
        schema::dropIfExists("cogs");
    }
}