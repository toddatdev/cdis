<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_reviews', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->date('received_date')->nullable();
            $table->tinyInteger('is_admin')->nullable();
            $table->date('admin_review_date')->nullable();
            $table->string('admin_status')->nullable();
            $table->string('admin_initials')->nullable();
            $table->date('reviewed_date')->nullable();
            $table->string('tech_status')->nullable();
            $table->string('tech_initials')->nullable();
            $table->text('return_reason')->nullable();
            $table->date('date_withdrawn')->nullable();

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
        Schema::dropIfExists('project_reviews');
    }
}
