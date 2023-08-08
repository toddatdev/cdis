<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('address_1', 255)->nullable();
            $table->string('address_2', 255)->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode', 30)->nullable();
            $table->integer('lat_deg')->nullable();
            $table->integer('lat_min')->nullable();
            $table->integer('lat_sec')->nullable();
            $table->integer('long_deg')->nullable();
            $table->integer('long_min')->nullable();
            $table->integer('long_sec')->nullable();

            $table->foreign('project_id')
                ->references('id')->on('projects')->onDelete('cascade');

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
        Schema::dropIfExists('project_locations');
    }
}
