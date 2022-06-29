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
        Schema::create('refers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Enrolle::class, 'enrolle_id')->constrained();
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->constrained();
            $table->string('case');
            $table->string('hospital_name');
            $table->longText('remark');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('refers');
    }
};
