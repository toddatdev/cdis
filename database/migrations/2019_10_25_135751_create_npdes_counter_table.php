<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNpdesCounterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('npdes_counter', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedInteger('county_id')->nullable();
            $table->integer('general');
            $table->integer('individual');

            $table->foreign('county_id')
                ->references('id')->on('counties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('npdes_counter');
    }
}
