<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentMethodsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'payment_methods', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( "title" );
			$table->text( "description" )->nullable();
			$table->text( "image" )->nullable();
			$table->tinyInteger( "type", false, true )
			      ->comment( "1=Offline and 2 = Online Without Card and 3 = Online With Card" )->default( 1 );
			$table->string( "mode", 50 )->nullable()
			      ->comment( "sandbox=Demo and live = Live" )->default( 'sandbox' );
			$table->string( "api_key" )->nullable();
			$table->string( "api_secret" )->nullable();
			$table->integer( "created_by", false, true );
			$table->integer( 'modified_by', false, true )->nullable();
			$table->tinyInteger( 'status' )->index()->default( 2 )
			      ->comment( '1=Completed, 2=Pending, 3=cancel' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'payment_methods' );
	}
}
