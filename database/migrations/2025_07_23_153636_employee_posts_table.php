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
        Schema::create('employee_posts', function (Blueprint $table) {
            $table->integer('employee_post_id')->primary();
            $table->string('employee_post_name');
            $table->timestamps();
        });
    }

public function down(): void // やり直す時に実行される
    {
        Schema::dropIfExists('employee_posts'); // もし posts テーブルがあれば削除する
    }
};
