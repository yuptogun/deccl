<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 개발 단계에서 멋모르고 다른 DB 테이블을 복사해 붙였기 때문에 어쩔수 없이 if 조건 추가
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->comment('닉네임/이름');
                $table->string('email')->unique()->comment('이메일');
                $table->timestamp('email_verified_at')->nullable()->comment('이메일 인증 일시');
                $table->string('password');
                $table->string('remember_token', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}