<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('intro');
            $table->string('image');
            $table->text('text');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            /*$table->unsignedInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedInteger('lang_id');
            $table->foreign('lang_id')->references('id')->on('langs');          */  
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
        /*$table->dropForeign('articles_user_id_foreign');*/
    }
}
