<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailsNasicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details_nasic', function (Blueprint $table) {
            $table->integer('id');
            $table->bigInteger('project_detail_id')->unsigned();
            $table->string('nasic')->nullable();

            $table->foreign('project_detail_id')
                ->references('id')->on('project_details')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_details_nasic');
    }
}
