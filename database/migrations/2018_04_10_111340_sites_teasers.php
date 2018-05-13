<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SitesTeasers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sites_teasers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')->references('id')->on('sites')->onDelete('cascade');
            $table->unsignedInteger('teaser_id');
            $table->foreign('teaser_id')->references('id')->on('teasers')->onDelete('cascade');
            $table->integer('num_order')->nullable();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sites_teasers');
        /*$table->dropForeign(['site_id']);
        $table->dropForeign(['teaser_id']);*/
    }
}
