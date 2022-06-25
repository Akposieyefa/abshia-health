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
            $table->string('title');
            $table->string('surname');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('gender');
            $table->string('phone_number');
            $table->date('dob');
            $table->string('address');
            $table->string('blood_group');
            $table->foreignIdFor(\App\Models\State::class, 'state_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(\App\Models\Lga::class, 'lga_id')->constrained()->onDelete('cascade');
            $table->string('town');
            $table->string('nok_name');
            $table->string('nok_address');
            $table->string('nok_phone');
            $table->string('nok_relationship');
            $table->foreignIdFor(\App\Models\Category::class, 'category_id')->constrained()->onDelete('cascade');
            $table->string('genotype');
            $table->string('marital_status');
            $table->string('no_of_dependants');
            $table->foreignIdFor(\App\Models\HealthCare::class, 'health_care_id')->constrained()->onDelete('cascade');
            $table->string('existing_medical_condition');
            $table->boolean('hypertension')->default(false);
            $table->boolean('sickle_cell')->default(false);
            $table->boolean('cancer')->default(false);
            $table->boolean('kidney_issue')->default(false);
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
