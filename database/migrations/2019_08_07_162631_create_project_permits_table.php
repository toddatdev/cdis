<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPermitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_permits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('npdes_number')->nullable();
            $table->date('received_date')->nullable();
            $table->date('pindi_date')->nullable();
            $table->date('final_inspection_date')->nullable();
            $table->date('permit_complete_date')->nullable();
            $table->date('permit_issued_date')->nullable();
            $table->date('permit_expiration_date')->nullable();
            $table->tinyInteger('is_notice_received')->nullable();
            $table->date('notice_received_date')->nullable();
            $table->tinyInteger('is_notice_acknowledged')->nullable();
            $table->tinyInteger('is_active')->nullable();

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
        Schema::dropIfExists('project_permit');
    }
}
