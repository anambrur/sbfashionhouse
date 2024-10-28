<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 11/14/17
 * Time: 11:23 AM
 */

namespace Mrksohag\Timezones;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class TimezonesController extends Controller {
	public function index( $timezone = null ) {
		$time = ( $timezone ) ? Carbon::now( $timezone ) : Carbon::now();

		return view( 'timezones::time', compact( 'time' ) );
	}
}