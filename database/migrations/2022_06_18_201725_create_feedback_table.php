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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('market_reality');
            $table->string('importance');
            $table->string('solution_platform');
            $table->string('key_things');
            $table->string('ideal_relationship');
            $table->string('facility_band');
            $table->string('patient_percentage');
            $table->string('second_third_investigation');
            $table->string('perceive_hmo');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feedback');
    }
};
