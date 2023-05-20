<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class down extends migration
{
    public function up(): void
    {
        schema::create('downs', function (blueprint $table) {
            $table->id();
            $table->string("title", 50);
            $table->string("addrs", 255);
            $table->boolean("status")->default(true);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("downs");
    }
}