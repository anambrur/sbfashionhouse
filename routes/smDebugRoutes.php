<?php
/**
 * All Debug routes are here.
 * User: mrksohag<engr.mrksohag@gmail.com>
 * Date: 11/13/17
 * Time: 5:23 PM
 */


Route::get( '/mailable', function () {
	$contactInfo             = $extra = new \stdClass();
	$contactInfo->email      = "engr.mrksohag@gmail.com";
//	$contactInfo->mobile     = "01715892032";
//	$contactInfo->phone      = "01715892032";
//	$contactInfo->service    = "SEARCH ENGINE OPTIMIZATION";
//	$contactInfo->service_id = 1;
//	$contactInfo->full_name  = "mizanur rahman khan";
//	$contactInfo->fullname   = "mizanur rahman khan";
	$contactInfo->message    = "All Doodle digital  Services Packages<br/>
                                Up To 30% Off";
	$contactInfo->discount_title    = "30% off all services packages";
	$contactInfo->available_title    = "offer available only 5 day";
	$contactInfo->btn_title    = "Order now";
	$contactInfo->btn_link    = "#";
	$contactInfo->image    = "header-text1.png";


	$extra->message = 'Gsjfhasdfasdfasdf';

	return new App\Mail\Offer( $contactInfo );
//	return new \App\Mail\InvoiceMail( 4, $extra );
} );


Route::group( [ 'namespace' => "Debug" ], function () {
	Route::get( "maintenance", "Debug@maintenance" );
//	Route::get( "optimize-image", "Debug@optimizeImage" );
//	Route::get( "regenerate-image", "Debug@regenerateAndOptimizeImage" );
//	Route::get( "plan-success", "Debug@planSuccess" );
//	Route::get( "backlink", "Debug@backlink" );
//	Route::get( '/test', 'Debug@test' );
//	Route::get( '/mail/{type}/{id}/{email?}', 'Debug@testMail' );
//
//	Route::get( "options", "Debug@options" );
//	Route::post( "options", "Debug@optionsRequest" );
} );

Route::get( '{url?}', 'Front\Page@page' );
// Display all SQL executed in Eloquent
//\Event::listen('Illuminate\Database\Events\QueryExecuted', function ($query) {
//    echo '<pre>';
//    echo'Query: ';
//    var_dump($query->sql);
//    echo'<br>Bindings: ';
//    var_dump($query->bindings);
//    echo'<br>Time: ';
//    var_dump($query->time);
//    echo '</pre>';
//});