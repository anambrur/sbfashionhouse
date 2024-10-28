<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'payments', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->integer( "order_id", false, true );
			$table->integer( "payment_method_id", false, true );
			$table->float( "paid", 10, 2 );
			$table->text( "transaction_id" )->nullable();
			$table->text( "return_url" )->nullable();
			$table->tinyInteger( 'status' )->index()
			      ->default( 2 )->comment( '1=Completed, 2=Pending, 3=cancel' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'payments' );
	}
}
