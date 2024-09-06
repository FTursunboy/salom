<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dateTime('sms_code_sent_at')->nullable()->after('sms_code');
            $table->integer('sms_code_sent_count')->nullable()->after('sms_code_sent_at');
            $table->integer('sms_confirm_try_count')->nullable()->after('sms_code_sent_count');
            $table->dateTime('sms_confirm_try_at')->nullable()->after('sms_confirm_try_count');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('sms_code_sent_at');
            $table->dropColumn('sms_code_sent_count');
            $table->dropColumn('sms_confirm_try_count');
            $table->dropColumn('sms_confirm_try_at');
        });
    }
};
