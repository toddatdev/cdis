<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('counties', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 70);
            $table->string('state', 50);
            $table->string('state_abbr', 2);
            $table->string('npdes_county_prefix', 5);
            $table->string('timezone', 50);
            $table->string('phone', 50);
            $table->text('address_1');
            $table->text('address_2');
            $table->string('county_code', 10);
            $table->string('fax', 20);
            $table->string('district', 20);
            $table->string('manager', 100);
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
        Schema::dropIfExists('counties');
    }
}
