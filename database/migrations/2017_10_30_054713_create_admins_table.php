<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration {
	public function up() {
		Schema::create( 'admins', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'username' )->unique();
			$table->string( 'email' )->unique();
			$table->string( 'firstname' )->index()->nullable();
			$table->string( 'lastname' )->index()->nullable();
			$table->string( 'password', 60 );
			$table->string( 'image' )->nullable();
			$table->integer( 'role_id' )->index()->unsigned()->default( 0 );
			$table->tinyInteger( 'status' )->index()->default( 2 )->comment( '1=active, 2=pending, 3=cancel' );
			$table->rememberToken();
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'admins' );
	}
}
