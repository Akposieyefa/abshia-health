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
        Schema::create('enrolles', function (Blueprint $table) {
            $table->id();
            $table->string('emp_id')->unique();
            $table->foreignUuid('user_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Agent::class, 'agent_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title')->nullable();
            $table->string('surname')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('dob')->nullable();
            $table->string('address')->nullable();
            $table->string('blood_group')->nullable();
            $table->foreignIdFor(\App\Models\State::class, 'state_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Lga::class, 'lga_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('town')->nullable();
            $table->string('nok_name')->nullable();
            $table->string('nok_address')->nullable();
            $table->string('nok_phone')->nullable();
            $table->string('nok_relationship')->nullable();
            $table->foreignIdFor(\App\Models\Category::class, 'category_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('genotype')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('no_of_dependants')->nullable();
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('existing_medical_condition')->nullable();
            $table->boolean('hypertension')->default(false)->nullable();
            $table->boolean('sickle_cell')->default(false)->nullable();
            $table->boolean('cancer')->default(false)->nullable();
            $table->boolean('kidney_issue')->default(false)->nullable();
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
        Schema::dropIfExists('enrolles');
    }
};
