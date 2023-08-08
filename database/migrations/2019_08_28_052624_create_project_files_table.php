<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_files', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('project_id')->unsigned();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('doctype');
            $table->string('filename', 255);
            $table->text('path');
            $table->string('auth_code', 255)->nullable();
            $table->string('memo', 255)->nullable();

            $table->foreign('project_id')
                ->references('id')
                ->on('projects')->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')->onDelete('set null');
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
        Schema::dropIfExists('project_files');
    }
}
