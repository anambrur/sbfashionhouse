<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBannerTitleToPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
	    Schema::table( 'pages', function ( Blueprint $table ) {
		    if ( !Schema::hasColumn( "pages", "banner_title" ) ) {
			    $table->string( "banner_title")->nullable()->after("page_subtitle");
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
		    if ( Schema::hasColumn( "pages", "banner_title" ) ) {
			    $table->dropColumn( "banner_title" );
		    }
	    } );
    }
}
