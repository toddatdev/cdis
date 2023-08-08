<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->integer('municipality_id')->unsigned()->nullable();
//            $table->string('name')->nullable();m
            $table->string('tax_parcel')->nullable();
            $table->string('watershed')->nullable();
            $table->string('receiving_stream')->nullable();
            $table->date('plan_date')->nullable();
            $table->string('ownership')->nullable();
            $table->string('ch_93_class')->nullable();
            $table->string('total_acres')->nullable();
            $table->string('disturbed_acres')->nullable();

            $table->foreign('municipality_id')
                ->references('id')->on('municipalities')->onDelete('set null');

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
        Schema::dropIfExists('project_details');
    }
}
