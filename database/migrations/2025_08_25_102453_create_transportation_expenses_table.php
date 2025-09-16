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
        Schema::create('transportation_expenses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('employee_id')->comment('申請者ID');
            $table->date('applied_date')->comment('申請日');
            $table->date('use_date')->comment('利用日');
            $table->string('route_start')->comment('始点');
            $table->string('route_end')->comment('終点');
            $table->integer('amount')->comment('金額');
            $table->boolean('submitted')->nullable()->comment('申請済み');
            $table->string('approver')->comment('承認者')->nullable();
            $table->string('recipient')->comment('受理者')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transportation_expenses');
    }
};
