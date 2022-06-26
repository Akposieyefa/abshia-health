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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Enrolle::class, 'enrolle_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->longText('appointment_reason');
            $table->date('appointment_date');
            $table->string('status')->default('pending');
            $table->timestamp('approved_date')->nullable();
            $table->longText('approval_comment')->nullable();
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
        Schema::dropIfExists('appointments');
    }
};
