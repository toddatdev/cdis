<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectPermitteesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_permittees', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_id')->unsigned();
            $table->date('received_date')->nullable();
            $table->date('reviewed_date')->nullable();
            $table->tinyInteger('acknowledged')->default(0);
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('address_1')->nullable();
            $table->string('address_2')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('fax', 30)->nullable();
            $table->string('email')->nullable();


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
        Schema::dropIfExists('project_permittees');
    }
}
