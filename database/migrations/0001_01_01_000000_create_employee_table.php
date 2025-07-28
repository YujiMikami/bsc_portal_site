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
        Schema::create('employees', function (Blueprint $table) {
            $table->integer('employee_id')->primary()->comment('社員番号');
            $table->string('employee_name')->comment('社員名（漢字）');
            $table->string('employee_name_furigana')->comment('社員名（かな）')->nullable();
            $table->string('gender')->comment('性別');
            $table->integer('employee_class_id')->comment('社員区分');
            $table->integer('department_id')->comment('部署ID')->nullable();
            $table->integer('affiliation_id')->comment('所属ID')->nullable();
            $table->integer('occupation_id')->comment('職種')->nullable();
            $table->date('birth_date')->comment('生年月日')->nullable();
            $table->date('hire_date')->comment('入社年月日');
            $table->string('post_code')->comment('郵便番号')->nullable();
            $table->string('prefecture')->comment('都道府県')->nullable();
            $table->string('municipalitie')->comment('市区郡')->nullable();
            $table->string('address_2')->comment('住所２')->nullable();
            $table->string('address_3')->comment('住所３')->nullable();
            $table->string('phone_number')->comment('電話番号')->nullable();
            $table->string('mobile_phone_number')->comment('携帯電話番号')->nullable();
            $table->date('final_academic_date')->comment('最終学歴年月')->nullable();
            $table->string('final_academic')->comment('最終学歴')->nullable();
            $table->date('work_history_1_date')->comment('職歴１年月')->nullable();
            $table->string('work_history_1')->comment('職歴１')->nullable();
            $table->date('work_history_2_date')->comment('職歴２年月')->nullable();
            $table->string('work_history_2')->comment('職歴２')->nullable();
            $table->date('work_history_3_date')->comment('職歴３年月')->nullable();
            $table->string('work_history_3')->comment('職歴３')->nullable();
            $table->date('work_history_4_date')->comment('職歴４年月')->nullable();
            $table->string('work_history_4')->comment('職歴４')->nullable();
            $table->date('work_history_5_date')->comment('職歴５年月')->nullable();
            $table->string('work_history_5')->comment('職歴５')->nullable();
            $table->date('work_history_6_date')->comment('職歴６年月')->nullable();
            $table->string('work_history_6')->comment('職歴６')->nullable();
            $table->date('work_history_7_date')->comment('職歴７年月')->nullable();
            $table->string('work_history_7')->comment('職歴７')->nullable();
            $table->date('work_history_8_date')->comment('職歴８年月')->nullable();
            $table->string('work_history_8')->comment('職歴８')->nullable();
            $table->date('work_history_9_date')->comment('職歴９年月')->nullable();
            $table->string('work_history_9')->comment('職歴９')->nullable();
            $table->date('work_history_10_date')->comment('職歴１０年月')->nullable();
            $table->string('work_history_10')->comment('職歴１０')->nullable();
            $table->string('license_1')->comment('資格１')->nullable();
            $table->string('license_2')->comment('資格２')->nullable();
            $table->string('license_3')->comment('資格３')->nullable();
            $table->string('license_4')->comment('資格４')->nullable();
            $table->string('license_5')->comment('資格５')->nullable();
            $table->date('social_insurance_Applicable_date')->comment('社会保険適用年月日')->nullable();
            $table->string('health_insurance')->comment('健康保険')->nullable();
            $table->string('basic_pension_number')->comment('基礎年金番号')->nullable();
            $table->string('welfare_pension_number')->comment('厚生年金番号')->nullable();
            $table->string('health_insurance_basic_reward_monthly_fee')->comment('健康保険標準報酬月額')->nullable();
            $table->string('health_insurance_grade')->comment('健康保険等級')->nullable();
            $table->string('pension_basic_reward_monthly_fee')->comment('年金標準報酬月額')->nullable();
            $table->string('pension_grade')->comment('年金等級')->nullable();
            $table->date('employment_applicable_date')->comment('雇用適用年月日')->nullable();
            $table->string('applicable_insurance')->comment('雇用保険番号')->nullable();
            $table->date('affiliation_updated_at')->comment('社員区分変更日')->nullable();
            $table->date('retirement_date')->comment('退職日')->nullable();
            $table->string('retirement_reason')->comment('退職理由')->nullable();
            $table->string('note')->comment('備考')->nullable();
            $table->string('password', 255);
            $table->integer('portal_role');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
