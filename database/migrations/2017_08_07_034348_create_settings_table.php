<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->increments('id');
	        $table->string('option_name')->unique();
	        $table->longText('option_value')->nullable();
	        $table->integer('created_by')->index()->unsigned()->nullable();
	        $table->integer('modified_by')->unsigned()->nullable();
	        $table->tinyInteger('autoload')->index()->default(0)->comment('0=No, 1=Yes');
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
        Schema::dropIfExists('settings');
    }
}
