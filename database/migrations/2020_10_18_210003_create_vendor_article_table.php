<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('vendor_article')) {
            Schema::create('vendor_article', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vendor_id')->constrained();
                $table->foreignId('article_id')->constrained();
                $table->string('article_code')->nullable()->comment('이 언론사에서 이 기사가 갖는 고유 코드값');
                $table->timestamps();
                $table->softDeletes();
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
        Schema::table('vendor_article', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['article_id']);
        });
        Schema::dropIfExists('vendor_article');
    }
}