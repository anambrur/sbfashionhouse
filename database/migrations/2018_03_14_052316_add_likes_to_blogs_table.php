<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLikesToBlogsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::table( 'blogs', function ( Blueprint $table ) {
			if ( !Schema::hasColumn( "blogs", "likes" ) ) {
				$table->integer( "likes", false, true)->default( 0 )->after("views");
			}
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::table( 'blogs', function ( Blueprint $table ) {
			if ( Schema::hasColumn( "blogs", "likes" ) ) {
				$table->dropColumn( "likes" );
			}
		} );
	}
}
