<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
	        $table->string('username', 50)->unique();
	        $table->string('email')->unique()->nullable();
	        $table->string('firstname')->index()->nullable();
	        $table->string('lastname')->index()->nullable();
	        $table->string('job_title')->index()->nullable();
	        $table->string('company')->index()->nullable();
	        $table->string('mobile')->unique()->nullable();
	        $table->string('password', 60);
	        $table->string('image')->nullable();
	        $table->text('street')->nullable();
	        $table->string('city')->nullable();
	        $table->string('zip', 5)->nullable();
	        $table->string('country')->nullable();
	        $table->string('state')->nullable();
            $table->rememberToken();
	        $table->tinyInteger('status')->index()->default(2)->comment('1=Active, 2=Pending, 3=Cancel');
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
        Schema::dropIfExists('users');
    }
}
