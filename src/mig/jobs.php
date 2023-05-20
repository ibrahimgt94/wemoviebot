<?php

namespace lord\mig;

use Illuminate\Database\Migrations\Migration as migration;
use Illuminate\Database\Schema\Blueprint as blueprint;
use Illuminate\Support\Facades\Schema as schema;

class jobs extends migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue');
            $table->longText('payload');
            $table->tinyInteger('attempts')->unsigned();
            $table->tinyInteger('reserved')->unsigned();
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
            $table->index(['queue', 'reserved', 'reserved_at']);
        });
    }

    public function down(): void
    {
        schema::dropIfExists("jobs");
    }
}