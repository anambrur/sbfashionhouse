<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuthIdToUsersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'users', function ( Blueprint $table ) {
			if ( Schema::hasTable( "users" ) ) {
				$table->string( "auth_id" )->nullable()->index()->after("id");
			}
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'users', function ( Blueprint $table ) {
			if ( Schema::hasColumn( "users", "auth_id" ) ) {
				$table->dropColumn( "auth_id" );
			}
		} );
	}
}
