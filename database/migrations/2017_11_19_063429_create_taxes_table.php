<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
	        $table->increments( 'id' );
	        $table->string( "title" );
	        $table->string( "country" );
	        $table->float( "tax", 5, 2 )->default( 0 );
	        $table->tinyInteger( "type", false, true )->default( 0 )
	              ->comment( '1 = Fixed and 2 = Percentage' );
	        $table->integer( "created_by", false, true );
	        $table->integer( 'modified_by', false, true )->nullable();
	        $table->tinyInteger( 'status' )->index()->default( 3 )
	              ->comment( '1=Completed, 2=Processing, 3=Pending, 4=cancel' );
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
        Schema::dropIfExists('taxes');
    }
}
