<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviewers', function (Blueprint $table) {

            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->string('email');
            $table->string('initials', 3);
            $table->string('district');
            $table->integer('extension')->default(0);
            $table->binary('signature')->nullable();
            $table->string('path')->nullable();
            $table->tinyInteger('is_active')->default(0);

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
        Schema::dropIfExists('reviewers');
    }
}
