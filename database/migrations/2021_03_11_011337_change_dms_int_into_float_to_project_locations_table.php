<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDmsIntIntoFloatToProjectLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('project_locations', function (Blueprint $table) {
            $table->float('lat_deg')->change();
            $table->float('lat_min')->change();
            $table->float('lat_sec')->change();
            $table->float('long_deg')->change();
            $table->float('long_min')->change();
            $table->float('long_sec')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_locations', function (Blueprint $table) {
            //
        });
    }
}
