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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('body');
            $table->dateTime('start_at')->nullable();
            $table->dateTime('end_at')->nullable();
            $table->timestamps();
        });

        // 中間テーブル（誰が既読か管理）
        Schema::create('notification_employee_account', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained('notifications')->onDelete('cascade');
            // まずカラムを作る。外部キーは型を合わせる必要がある。
            $table->unsignedInteger('employee_account_id');
            $table->foreign('employee_account_id')->references('employee_id')->on('employee_accounts')->cascadeOnDelete();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('notification_employee_account');
    }
};
