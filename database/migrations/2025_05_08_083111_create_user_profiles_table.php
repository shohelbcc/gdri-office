<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('photo')->nullable();
            $table->string('address')->nullable(); 
            $table->string('division')->nullable();
            $table->string('district')->nullable();
            $table->string('thana')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('emp_id')->nullable();
            $table->string('designation')->nullable();
            $table->date('dob')->nullable();
            $table->string('work_office')->nullable();
            $table->string('employee_status')->nullable();
            $table->text('links')->nullable();
            $table->longText('biography')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
