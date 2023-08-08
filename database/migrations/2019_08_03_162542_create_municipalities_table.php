<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMunicipalitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('municipalities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('municipal_code', 10);
            $table->text('address');
            $table->string('city');
            $table->string('state', 20);
            $table->string('zipcode', 15);
            $table->string('phone_number', 20);
            $table->string('manager_secretary');
            $table->string('ceo');
            $table->string('engineer');
            $table->integer('county_id');

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
        Schema::dropIfExists('municipalities');
    }
}
