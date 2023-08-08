<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTimeTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_time_tracking', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_id')->unsigned();
            $table->integer('reviewer_id')->unsigned()->nullable();
            $table->string('trx_number')->nullable();
            $table->date('trx_date')->nullable();
            $table->string('time_category')->nullable();
            $table->string('hours', 10)->nullable();
            $table->string('submit_type', 2)->nullable();  //new or resubmit
            $table->string('entered_by', 60)->nullable();
            $table->date('entered_date')->nullable();
            

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')->onDelete('cascade');

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
        Schema::dropIfExists('project_time_tracking');
    }
}
