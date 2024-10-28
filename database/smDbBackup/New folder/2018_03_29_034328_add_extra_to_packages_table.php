<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddExtraToPackagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'packages', function ( Blueprint $table ) {
			if ( !Schema::hasColumn( "packages", "extra" ) ) {
				$table->longText( "extra")->nullable()->after("mover_img");
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
			if ( Schema::hasColumn( "packages", "extra" ) ) {
				$table->dropColumn( "extra" );
			}
		} );
	}
}
