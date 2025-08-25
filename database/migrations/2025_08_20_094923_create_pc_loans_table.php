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
        Schema::create('pc_loans', function (Blueprint $table) {
            $table->id();
            $table->string('pc_number');
            $table->string('service_tag');
            $table->string('os')->nullable();
            $table->string('pc_name')->nullable();
            $table->string('pin')->nullable();
            $table->string('office')->nullable();
            $table->string('office_lisence')->nullable();
            $table->string('security_soft')->nullable();
            $table->string('bios_pass')->nullable();
            $table->string('foticlient_account')->nullable();
            $table->string('foticlient_pass')->nullable();
            $table->unsignedInteger('employee_id')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('wifi')->nullable();
            $table->string('ms_account')->nullable();
            $table->string('ms_pass')->nullable();
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
        Schema::dropIfExists('pc_loans');
    }
};
