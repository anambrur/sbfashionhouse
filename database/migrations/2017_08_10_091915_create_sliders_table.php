<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidersTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create( 'sliders', function ( Blueprint $table ) {
			$table->increments( 'id' );
			$table->string( 'title' );
			$table->text( 'description' )->nullable();
			$table->string( 'image' );
			$table->string( 'extra' );
			$table->integer( 'created_by' )->index()->unsigned()->nullable();
			$table->integer( 'modified_by' )->unsigned()->nullable();
			$table->tinyInteger( 'status' )->index()->default( 2 )->comment( '1=active, 2=pending, 3=cancel' );
			$table->timestamps();
		} );
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::dropIfExists( 'sliders' );
	}
}
