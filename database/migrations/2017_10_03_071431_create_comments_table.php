<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
	        $table->increments('id');
	        $table->integer('commentable_id')->index()->unsigned();
	        $table->string('commentable_type');
	        $table->integer('p_c_id')->index()->unsigned();
	        $table->longText('comments');
	        $table->integer('created_by')->index()->unsigned()->nullable();
	        $table->integer('modified_by')->unsigned()->nullable();
	        $table->tinyInteger('status')->index()->default(2)->comment('1=active, 2=pending, 3=cancel');
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
        Schema::dropIfExists('comments');
    }
}
