<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/14/17
 * Time: 11:26 AM
 */
Route::group( [ "namespace" => "Mrksohag\Timezones" ], function () {
	Route::get( "timezones/{timezone?}", "TimezonesController@index" );
} );