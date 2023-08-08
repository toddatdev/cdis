<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspecFindingsViolationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspec_findings_violations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('inspec_findings_id')->unsigned();

            $table->char('violation', 2);

            $table->foreign('inspec_findings_id')
                ->references('id')->on('inspec_findings')->onDelete('cascade');

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
        Schema::dropIfExists('inspec_findings_violations');
    }
}
