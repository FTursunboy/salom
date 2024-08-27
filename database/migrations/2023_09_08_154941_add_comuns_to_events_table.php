<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->foreignUuid('country_id')->after('event_category_id')->nullable()->constrained();
            $table->foreignUuid('city_id')->after('country_id')->nullable()->constrained();
            $table->tinyText('phones')->nullable()->after('show_ticket_count');
            $table->tinyText('sites')->nullable()->after('phones');
        });
    }

    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Locations\Country\Country::class);
            $table->dropForeignIdFor(\App\Models\Locations\City\City::class);
            $table->dropColumn('country_id');
            $table->dropColumn('city_id');
            $table->dropColumn('phones');
            $table->dropColumn('sites');
        });
    }
};
