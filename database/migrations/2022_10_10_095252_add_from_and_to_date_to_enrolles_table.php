<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('enrolles', function (Blueprint $table) {
            $table->date('from_date')->after('is_subscribed')->nullable();
            $table->date('to_date')->after('from_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('enrolles', function (Blueprint $table) {
            $table->dropColumn(['from_date', 'to_date']);
        });
    }
};
