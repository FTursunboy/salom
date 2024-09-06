<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('popular_places', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('latitude');
            $table->string('longitude');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('popular_places');
    }
};
