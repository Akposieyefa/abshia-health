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
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->constrained();
            $table->foreignIdFor(\App\Models\Enrolle::class, 'enrolle_id')->constrained();
            $table->date('date_of_admission');
            $table->date('date_of_discharge');
            $table->longText('treatment_details');
            $table->longText('diagnosis');
            $table->longText('investigations');
            $table->unsignedBigInteger('cost');
            $table->string('payment_status')->default('pending');
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
        Schema::dropIfExists('claims');
    }
};
