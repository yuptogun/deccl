<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * URL 컬럼들 길이를 최대 2083자로 변경
 */
class LengthenUrlFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('articles')) {
            Schema::table('articles', function ($table) {
                $table->string('url', 2083)->change();
                $table->string('thumbnail', 2083)->change();
            });
        }
        if (Schema::hasTable('vendors')) {
            Schema::table('vendors', function ($table) {
                $table->string('url', 2083)->change();
            });
        }
        if (Schema::hasTable('user_properties')) {
            Schema::table('user_properties', function ($table) {
                $table->string('profile_picture', 2083)->change();
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
        // 그렇다고 길이를 다시 줄이지는 않는다.
    }
}
