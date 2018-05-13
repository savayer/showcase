<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTeasersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::table('teasers', function(Blueprint $table) {
          $table->string('image')->nullable()->change();
          $table->string('image2')->nullable()->change();
          $table->string('image1gif')->nullable();
          $table->boolean('gif')->default(false);
      });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teasers');
    }
}
