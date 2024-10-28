<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddThreeFieldsToCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table( 'cases', function ( Blueprint $table ) {
		    if ( !Schema::hasColumn( "cases", "likes" ) ) {
			    $table->integer( "likes", false, true)->default( 0 )->after("views");
		    }
		    if ( !Schema::hasColumn( "cases", "comments" ) ) {
			    $table->integer( "comments", false, true)->default( 0 )->after("likes");
		    }
		    if ( !Schema::hasColumn( "cases", "case_style" ) ) {
			    $table->tinyInteger("case_style")->default(0)->comment('1=Normal, 1=Affiliate')->after("site_link");
		    }
	    } );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
	    Schema::table( 'cases', function ( Blueprint $table ) {
		    if ( Schema::hasColumn( "cases", "likes" ) ) {
			    $table->dropColumn( "likes" );
		    }
		    if ( Schema::hasColumn( "cases", "comments" ) ) {
			    $table->dropColumn( "comments" );
		    }
		    if ( Schema::hasColumn( "cases", "case_style" ) ) {
			    $table->dropColumn( "case_style" );
		    }
	    } );
    }
}
