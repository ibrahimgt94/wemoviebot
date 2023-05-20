<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class data extends migration
{
    public function up(): void
    {
        schema::create('datas', function (blueprint $table) {
            $table->string("name", 90)->primary();
            $table->string("value")->default("a:0:{}");
        });
    }

    public function down(): void
    {
        schema::dropIfExists("datas");
    }
}