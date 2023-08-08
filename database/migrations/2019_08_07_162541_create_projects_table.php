<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('county_id')->nullable();

            $table->string('entry_number')->nullable();
            $table->string('name');
            $table->string('plan_type');
            $table->unsignedInteger('is_closed')->default(0);
            $table->text('memo')->nullable();

            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('set null');

            $table->foreign('county_id')
                ->references('id')->on('counties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
