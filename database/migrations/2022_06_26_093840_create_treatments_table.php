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
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Enrolle::class, 'enrolle_id')->constrained();
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->constrained();
            $table->string('verified_by');
            $table->timestamp('date_and_time');
            $table->boolean('is_capitated')->default(false);
            $table->boolean('is_ffs')->default(false);
            $table->string('height');
            $table->string('weight');
            $table->string('blood_pressure');
            $table->string('pulse');
            $table->string('respiration');
            $table->string('temperature');
            $table->string('treatment_give');
            $table->string('drugs');
            $table->string('cost_of_treatment');
            $table->boolean('is_referred')->default(false);
            $table->longText('summary');
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
        Schema::dropIfExists('treatments');
    }
};
