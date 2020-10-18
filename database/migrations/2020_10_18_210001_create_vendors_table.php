<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('code')->comment('언론사 고유코드');
            $table->string('name')->comment('언론사 이름');
            $table->string('description')->comment('간략한 설명');
            $table->string('url')->comment('공식홈페이지 URL');
            $table->text('pattern')->nullable()->comment('어떤 Article 의 url 이 이 regex 에 매치되면 이 Vendor 의 Article 인 것으로 함');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendors');
    }
}