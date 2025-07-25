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
        Schema::create('safeties', function (Blueprint $table) {
        $table->integer('safety_employee_id')->primary();
        $table->string('safety_employee_name');
        $table->string('safety_status');
        $table->text('injury_status');
        $table->string('can_work');
        $table->timestamps();
        $table->softDeletes();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('safeties');
    }
};
