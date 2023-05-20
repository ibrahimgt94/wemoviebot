<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class group extends migration
{
    public function up(): void
    {
        schema::create('groups', function (blueprint $table) {
            $table->id();
            $table->string("name", 50)->unique();
            $table->string("title", 100);
            $table->string("desc", 100);
            $table->integer("parent")->unsigned()->nullable();
            $table->boolean("status")->default(true);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("groups");
    }
}