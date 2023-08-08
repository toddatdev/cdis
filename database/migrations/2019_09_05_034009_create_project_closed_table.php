<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectClosedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_closed', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_id')->unsigned();

            $table->string('box_number')->nullable();
//            $table->string('permit_number')->nullable();
            $table->string('reason')->nullable();
            $table->text('notes')->nullable();
            $table->date('closing_date')->nullable();

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
        Schema::dropIfExists('project_closed');
    }
}
