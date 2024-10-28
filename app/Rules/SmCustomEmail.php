<?php

namespace App\Rules;

use App\SM\SM;
use Illuminate\Contracts\Validation\Rule;

class SmCustomEmail implements Rule {
	private $smError = 'Invalid Email.';

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
		if ( strlen( $value ) > 0 ) {
			$this->smError = SM::emailValidate( $value );

			return $this->smError === '' ? true : false;
		}

		return true;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return $this->smError;
	}


}
