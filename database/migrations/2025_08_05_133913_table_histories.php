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
        Schema::create('table_histories', function (Blueprint $table) {
            $table->id('history_id');
            $table->string('table_name')->comment('テーブル名');
            $table->integer('target_id')->comment('ID');
            $table->string('target_name')->comment('名前');
            $table->string('action')->comment('行動');
            $table->string('item_name')->comment('項目名')->nullable(true);
            $table->string('before_update')->comment('更新前')->nullable(true);
            $table->string('after_update')->comment('更新後')->nullable(true);
            $table->string('responder')->comment('対応者');
            $table->date('compatible_date')->comment('対応日');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('table_history');
    }
};
