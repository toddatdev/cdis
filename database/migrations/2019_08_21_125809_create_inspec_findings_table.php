<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspecFindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspec_findings', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('inspection_id')->unsigned();

            $table->tinyInteger('violations_obs')->default(0);
            $table->tinyInteger('sopd_csl')->default(0);
            $table->tinyInteger('scpp_csl')->default(0);
            $table->tinyInteger('dept_comply')->default(0);
            $table->tinyInteger('pcsm_comply')->default(0);
            $table->tinyInteger('no_meeting')->default(0);
            $table->tinyInteger('no_proofs')->default(0);
            $table->tinyInteger('no_permit')->default(0);
            $table->tinyInteger('violation_exists')->default(0);


            $table->text('cam')->nullable();
            $table->string('fui_date')->nullable();
            $table->string('date')->nullable();
            $table->string('email')->nullable();

            $table->foreign('inspection_id')
                ->references('id')->on('inspections')->onDelete('cascade');

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
        Schema::dropIfExists('inspec_findings');
    }
}
