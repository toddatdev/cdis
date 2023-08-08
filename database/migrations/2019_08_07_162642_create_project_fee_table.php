<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_fees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->dateTime('received_date');
            $table->tinyInteger('is_admin')->nullable();
            $table->char('submission_type')->nullable(); //new or resubmit
            $table->string('review_number')->nullable();
            $table->integer('disturbed_acres')->nullable();
            $table->integer('total_acres')->nullable();
            $table->string('fee_type')->nullable();  // CWF Fees, Dist Fees, etc.
            $table->decimal('fee_amount', 20, 2)->default(0.00)->nullable();
            $table->string('check_number')->nullable();
            $table->string('payer_name')->nullable();
            $table->string('check_date')->nullable();

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
        Schema::dropIfExists('project_fee');
    }
}
