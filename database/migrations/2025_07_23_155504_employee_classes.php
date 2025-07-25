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
        Schema::create('employee_classes', function (Blueprint $table) {
            $table->integer('employee_class_id')->primary();
            $table->string('employee_class_name');
            $table->timestamps();
            $table->softDeletes();
        });
    }

public function down(): void // やり直す時に実行される
    {
        Schema::dropIfExists('employee_classes'); // もし posts テーブルがあれば削除する
    }
};
