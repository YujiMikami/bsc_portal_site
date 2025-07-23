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
        Schema::create('affiliations', function (Blueprint $table) {
            $table->integer('affiliation_id')->unique();
            $table->string('affiliation_name');
            $table->text('affiliation_explanation')->nullable();
        });
    }

public function down(): void // やり直す時に実行される
    {
        Schema::dropIfExists('affiliations'); // もし posts テーブルがあれば削除する
    }
};
