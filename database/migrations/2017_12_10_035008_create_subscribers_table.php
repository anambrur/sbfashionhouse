<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscribersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'subscribers', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'email' )->unique();
			$table->string( 'firstname' )->index()->nullable();
			$table->string( 'lastname' )->index()->nullable();
			$table->string( 'ip' )->nullable();
			$table->string( 'city' )->nullable();
			$table->string( 'state' )->nullable();
			$table->string( 'country' )->nullable();
			$table->string( 'extra' )->nullable();
			$table->tinyInteger( 'status' )->index()->default( 1 )->comment( '1=Active, 0=Disabled' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'subscribers' );
	}
}
