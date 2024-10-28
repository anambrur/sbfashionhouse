<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class SmYearHypenMonth implements Rule {
	/**
	 * Create a new rule instance.
	 *
	 * @return void
	 */
	public function __construct() {
		//
	}

	/**
	 * Determine if the validation rule passes.
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 *
	 * @return bool
	 */
	public function passes( $attribute, $value ) {
		if ( strpos( $value, '/' ) !== FALSE ) {
			$date = explode( '/', $value );
			if (
				isset( $date[0] ) && strlen( $date[0] ) == 2 &&
				isset( $date[1] ) && strlen( $date[1] ) == 4

			) {
				return true;
			}

			return false;
		}

		return false;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return 'Your :attribute is invalid!';
	}
}
