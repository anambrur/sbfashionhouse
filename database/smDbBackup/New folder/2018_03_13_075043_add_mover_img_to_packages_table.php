<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoverImgToPackagesTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'packages', function ( Blueprint $table ) {
			if ( ! Schema::hasColumn( 'packages', 'mover_img' ) ) {
				$table->text( 'mover_img' )->nullable()->after( "sale_amount" );
			}
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'packages', function ( Blueprint $table ) {
			if ( Schema::hasColumn( 'packages', 'style' ) ) {
				$table->dropColumn( 'mover_img' );
			}
		} );
	}
}
