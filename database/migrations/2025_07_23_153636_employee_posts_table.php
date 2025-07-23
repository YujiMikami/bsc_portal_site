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
            $table->integer('post_id')->unique();
            $table->string('post_name');
        });
    }

public function down(): void // やり直す時に実行される
    {
        Schema::dropIfExists('employee_posts'); // もし posts テーブルがあれば削除する
    }
};
