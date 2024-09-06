<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('id_inc');
            $table->boolean('free_entrance')->default(false);
        });

        DB::update("ALTER TABLE `events` CHANGE `id_inc` `id_inc` INT NOT NULL AUTO_INCREMENT,ADD KEY (`id_inc`);");
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('id_inc');
            $table->dropColumn('free_entrance');
        });
    }
};
