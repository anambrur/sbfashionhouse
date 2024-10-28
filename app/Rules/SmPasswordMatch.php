<?php

namespace App\Rules;

use App\User;
use Illuminate\Contracts\Validation\Rule;

class SmPasswordMatch implements Rule {
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
		return \Hash::check( $value, \Auth::user()->getAuthPassword() ) ? true : false;
	}

	/**
	 * Get the validation error message.
	 *
	 * @return string
	 */
	public function message() {
		return 'Your provided current :attribute did not match with current :attribute.';
	}
}
