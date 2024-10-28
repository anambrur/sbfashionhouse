<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerSubtitleToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table( 'pages', function ( Blueprint $table ) {
		    if ( !Schema::hasColumn( "pages", "banner_subtitle" ) ) {
			    $table->text( "banner_subtitle")->nullable()->after("banner_title");
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
	    Schema::table( 'pages', function ( Blueprint $table ) {
		    if ( Schema::hasColumn( "pages", "banner_subtitle" ) ) {
			    $table->dropColumn( "banner_subtitle" );
		    }
	    } );
    }
}
