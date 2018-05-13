<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('articles', function(Blueprint $table) {
          $table->unsignedInteger('country_id');
          $table->foreign('country_id')->references('id')->on('countries');
          $table->unsignedInteger('lang_id');
          $table->foreign('lang_id')->references('id')->on('langs');
          $table->string('context_name')->nullable();
          $table->string('context_description')->nullable();
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
    }
}
