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
        Schema::create('smartphone_loans', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('department_1')->nullable();
            $table->string('department_2')->nullable();
            $table->string('affiliation')->nullable();
            $table->string('email')->nullable();
            $table->date('loan_start_at')->nullable();
            $table->date('loan_end_at')->nullable();
            $table->string('model')->nullable();
            $table->string('guarantee')->comment('あんしん保証パック')->nullable();
            $table->string('updated_by')->comment('更新者');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smartphone_loans');
    }
};
