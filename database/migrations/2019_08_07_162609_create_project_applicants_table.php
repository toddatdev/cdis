<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectApplicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_applicants', function (Blueprint $table) {
            $table->integer('id');
            $table->bigInteger('project_id')->unsigned();
            $table->string('name')->nullable();
            $table->string('company_name')->nullable();
            $table->text('address_1')->nullable();
            $table->text('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('phone_number_ext')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('email')->nullable();


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
        Schema::dropIfExists('project_applicants');
    }
}
