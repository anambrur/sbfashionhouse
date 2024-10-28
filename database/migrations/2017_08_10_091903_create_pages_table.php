<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('menu_title')->index();
	        $table->string('page_title')->index();
	        $table->string('page_subtitle')->nullable();
	        $table->string('banner_image')->nullable();
	        $table->longText('content');
	        $table->string('slug')->unique();
	        $table->string('template')->nullable();
	        $table->integer('views')->index()->unsigned()->default(0);
	        $table->string( "seo_title" )->nullable();
	        $table->text('meta_key')->nullable();
	        $table->text('meta_description')->nullable();
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
        Schema::dropIfExists('pages');
    }
}
