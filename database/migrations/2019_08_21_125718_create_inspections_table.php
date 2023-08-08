<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('entry_number');
            $table->integer('technician')->nullable();
            $table->string('report_number')->nullable();
            $table->string('project_name')->nullable();
            $table->string('inspection_date')->nullable();
            $table->string('inspection_time')->nullable();
            $table->string('designated')->nullable();
            $table->string('weather')->nullable();
            $table->string('site_rep')->nullable();
            $table->string('site_rep_title')->nullable();
            $table->string('site_insp')->nullable();  //site inspector
            $table->string('site_insp_title')->nullable();  //site inspector title
            $table->string('inspection_type')->nullable();
            $table->string('tax_parcel_number')->nullable();
            $table->tinyInteger('photos_taken')->default(0);
            $table->string('site_description')->nullable();

            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('inspections');
    }
}
