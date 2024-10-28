<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\RedirectsUsers;
use App\Http\Controllers\Front\HomeController;
use Validator;

class ResetPassword extends Controller {

	protected $redirectTo;

	use RedirectsUsers;

	public function __construct() {
		$this->redirectTo = '/login';
	}

	public function showResetForm( Request $request, $token = null ) {
		$data["title"] = "Reset Password";
		$data['token'] = $token;

		return view( "frontend.common.resetpassword", $data );
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function reset( Request $request ) {
		$validator = Validator::make( $request->all(), $this->rules() );
		if ( $validator->fails() ) {
			if ( $request->expectsJson() ) {
				return response()->json( $validator->errors(), 400 );
			} else {
				return back()->with( "errors", $validator->errors() )->withInput();
			}
		}

		// Here we will attempt to reset the user's password. If it is successful we
		// will update the password on an actual user model and persist it to the
		// database. Otherwise we will parse the error and return the response.
		$response = $this->broker()->reset(
			$this->credentials( $request ), function ( $user, $password ) {
			$this->resetPassword( $user, $password );
		}
		);
		// If the password was successfully reset, we will redirect the user back to
		// the application's home authenticated view. If there is an error we can
		// redirect them back to where they came from with their error message.
		return $response == Password::PASSWORD_RESET ? $this->sendResetResponse( $request, $response ) : $this->sendResetFailedResponse( $request, $response );
	}

	/**
	 * Get the password reset validation rules.
	 *
	 * @return array
	 */
	protected function rules() {
		return [
			'token'    => 'required',
			'email'    => 'required|email',
			'password' => 'required|confirmed|min:6',
		];
	}

	/**
	 * Get the password reset validation error messages.
	 *
	 * @return array
	 */
	protected function validationErrorMessages() {
		return [];
	}

	/**
	 * Get the password reset credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return array
	 */
	protected function credentials( Request $request ) {
		return $request->only(
			'email', 'password', 'password_confirmation', 'token'
		);
	}

	/**
	 * Reset the given user's password.
	 *
	 * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
	 * @param  string $password
	 *
	 * @return void
	 */
	protected function resetPassword( $user, $password ) {
		$user->forceFill( [
			'password'       => bcrypt( $password ),
			'remember_token' => Str::random( 60 ),
		] )->save();

		$this->guard()->login( $user );
	}

	/**
	 * Get the response for a successful password reset.
	 *
	 * @param  string $response
	 *
	 * @return \Illuminate\Http\Response
	 */
	protected function sendResetResponse( Request $request, $response ) {
		if ( $request->expectsJson() ) {

			$data['username'] = Auth::user()->username;

			return response()->json( $data, 202 );
		} else {
			return redirect( "home" )
				->with( 'status', trans( $response ) );
		}
	}

	/**
	 * Get the response for a failed password reset.
	 *
	 * @param  \Illuminate\Http\Request
	 * @param  string $response
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendResetFailedResponse( Request $request, $response ) {
		if ( $request->expectsJson() ) {
			return response()->json( [ 'email' => trans( $response ) ], 422 );
		} else {
			return redirect()->back()
			                 ->withInput( $request->only( 'email' ) )
			                 ->withErrors( [ 'email' => trans( $response ) ] );
		}
	}

	/**
	 * Get the broker to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\PasswordBroker
	 */
	public function broker() {
		return Password::broker();
	}

	/**
	 * Get the guard to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard() {
		return Auth::guard();
	}

}
