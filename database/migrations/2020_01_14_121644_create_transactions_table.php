<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('project_id')->unsigned();
            $table->decimal('totalacres', 19, 3)->nullable();
            $table->decimal('tobedisturb', 19, 3)->nullable();
            $table->decimal('tbd_fee', 19, 2)->nullable();
            $table->string('rev_number')->nullable();
            $table->string('plan_date', 10)->nullable();
            $table->date('received')->nullable();
            $table->string('reviewed', 10)->nullable();
            $table->decimal('dist_fee', 19, 2)->nullable();

            $table->string('tech_init')->nullable();
            $table->string('dist_chknum')->nullable();

            $table->string('mccd_cwf_payor')->nullable();
            $table->string('distfee_payor')->nullable();
            $table->string('tech_status', 100)->nullable();

            $table->string('nr', 10)->nullable();
            $table->string('entry')->nullable();

            $table->string('mccd_cwf_chknum')->nullable();
            $table->decimal('mccd_cwf_fee', 19, 2)->nullable();
            $table->string('tbdfee_payor')->nullable();

            $table->string('date_wd', 10)->nullable();

            $table->string('p_h_fee', 100)->nullable();
            $table->string('expedite_fee', 100)->nullable();

            $table->string('exp_check_num')->nullable();
            $table->date('exp_check_date')->nullable();
            $table->string('exp_payor')->nullable();

            $table->string('admin_rev_date', 10)->nullable();
            $table->string('admin_status', 100)->nullable();
            $table->string('return_reason')->nullable();
            $table->string('admin_init', 50)->nullable();


            $table->string('tbdfee_chknum', 50)->nullable();

            $table->string('tbdfee_chkdate', 10)->nullable();
            $table->string('dist_fee_chkdate', 10)->nullable();
            $table->string('mccd_cwf_chkdate', 10)->nullable();

            $table->tinyInteger('is_admin')->default(0);
            $table->string('fee_type', 10)->nullable();

            $table->integer('county_id')->unsigned();

            $table->string('conservationdistrict');

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
}
