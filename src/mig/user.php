<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class user extends migration
{
    public function up(): void
    {
        schema::create('users', function (blueprint $table) {
            $table->id();
            $table->string("fname")->nullable();
            $table->string("lname")->nullable();
            $table->string("username")->unique();
            $table->integer("coin")->unsigned()->default(0);
            $table->boolean("sex")->nullable();
            $table->tinyInteger("age")->unsigned()->nullable();
            $table->bigInteger("parent")->nullable()->unsigned();
            $table->integer("subset")->unsigned()->default(0);
            $table->string("payment", 30)->nullable();
            $table->boolean("status")->default(true);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("users");
    }
}