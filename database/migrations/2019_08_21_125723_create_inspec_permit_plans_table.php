<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspecPermitPlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspec_permit_plans', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('inspection_id')->unsigned();
            $table->tinyInteger('written_erosion_required')->default(0);
            $table->tinyInteger('post_const_written')->default(0); //post construction written
            $table->tinyInteger('written_erosion_requested')->default(0);
            $table->tinyInteger('pcsm_requested')->default(0);
            $table->tinyInteger('esp_required')->default(0);
            $table->tinyInteger('npdes_required')->default(0);
            $table->tinyInteger('phased_const')->default(0);
            $table->tinyInteger('non_phased_const')->default(0);
            $table->tinyInteger('prc')->default(0);
            $table->tinyInteger('rsbd')->default(0);
            $table->tinyInteger('gov')->default(0);
            $table->tinyInteger('utl')->default(0);
            $table->tinyInteger('sws')->default(0);
            $table->tinyInteger('rrs')->default(0);
            $table->tinyInteger('prrs')->default(0);
            $table->tinyInteger('cmin')->default(0);
            $table->tinyInteger('recf')->default(0);
            $table->tinyInteger('aga')->default(0);
            $table->tinyInteger('pl')->default(0);
            $table->tinyInteger('silv')->default(0);
            $table->tinyInteger('other')->default(0);
            $table->string('other_value')->nullable();

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
        Schema::dropIfExists('inspec_permit_plans');
    }
}
