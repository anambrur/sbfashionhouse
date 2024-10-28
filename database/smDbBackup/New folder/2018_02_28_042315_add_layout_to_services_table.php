<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLayoutToServicesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'services', function ( Blueprint $table ) {
			if ( Schema::hasTable( "services" ) ) {
				$table->tinyInteger( "layout" )->nullable()->default( 0 );
			}
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'services', function ( Blueprint $table ) {
			if ( Schema::hasTable( "services" ) && Schema::hasColumn( "services", "layout" ) ) {
				$table->dropColumn( "layout" );
			}
		} );
	}
}
