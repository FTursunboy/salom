<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('event_status_id')->constrained();
            $table->foreignUuid('event_category_id')->constrained();
            $table->foreignUuid('created_by_user_id')->constrained('users');
            $table->string('title');
            $table->text('description');
            $table->longText('text');
            $table->string('photo');
            $table->integer('ticket_amount')->nullable();
            $table->integer('ticket_count')->nullable();
            $table->integer('registered_users')->default(0);
            $table->string('address');
            $table->integer('view_count')->default(0);
            $table->enum('event_type', ['free', 'paid'])->default('free');
            $table->boolean('show_ticket_count')->nullable()->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
