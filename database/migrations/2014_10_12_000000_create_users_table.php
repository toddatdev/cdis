<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {

            $table->engine = 'InnoDB';

            $table->increments('id');

            $table->unsignedInteger('county_id')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('username', 100)->index();
            $table->string('icis_username', 100)->nullable();
            $table->string('email')->unique();
            $table->string('role', 70)->nullable();
            $table->tinyInteger('is_logged_in')->default(0);
            $table->tinyInteger('is_active')->default(0);
            $table->dateTime('last_activity')->nullable();
            $table->tinyInteger('login_attempt')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('is_reviewer')->default(0);
            $table->rememberToken();
            $table->timestamps();

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
        Schema::dropIfExists('users');
    }
}
