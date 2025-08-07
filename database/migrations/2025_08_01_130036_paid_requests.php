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
        Schema::create('paid_requests', function (Blueprint $table) {
            $table->id();
            $table->date('application_date')->comment('申請日');
            $table->integer('employee_id')->comment('申請者ID');
            $table->string('affiliation')->comment('申請者所属');
            $table->string('employee_name')->comment('申請者名');
            $table->date('start_date')->comment('開始日');
            $table->date('end_date')->comment('終了日')->nullable(true);
            $table->integer('days')->comment('日数');
            $table->string('distinction')->comment('区別');
            $table->string('reason')->comment('理由');
            $table->string('note')->comment('備考')->nullable(true);
            $table->string('approver')->comment('承認者')->nullable(true);
            $table->string('recipient')->comment('受理者')->nullable(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paid_leave_requests');
    }
};
