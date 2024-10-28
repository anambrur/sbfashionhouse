<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStyleToSlidersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'sliders', function ( Blueprint $table ) {
			if ( ! Schema::hasColumn( 'sliders', 'style' ) ) {
				$table->string( 'style' )->after( "id" );
			}
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'sliders', function ( Blueprint $table ) {
			if ( Schema::hasColumn( 'sliders', 'style' ) ) {
				$table->dropColumn( 'style' );
			}
		} );
	}
}
