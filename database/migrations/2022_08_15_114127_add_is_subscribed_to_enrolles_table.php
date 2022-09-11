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
    public function up()
    {
        Schema::table('enrolles', function (Blueprint $table) {
            $table->foreignIdFor(\App\Models\Plan::class, 'plan_id')->nullable()->after('kidney_issue')->constrained();
            $table->boolean('is_subscribed')->default(false)->after('plan_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolles', function (Blueprint $table) {
            $table->dropColumn(['is_subscribed']);
        });
    }
};
