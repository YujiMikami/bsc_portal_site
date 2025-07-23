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
        Schema::create('departments', function (Blueprint $table) {
            $table->integer('department_id')->unique();
            $table->string('department_name');
            $table->text('department_explanation')->nullable();
        });
    }

public function down(): void // やり直す時に実行される
    {
        Schema::dropIfExists('departments'); // もし posts テーブルがあれば削除する
    }
};
