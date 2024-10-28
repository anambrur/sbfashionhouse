<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SM\SM;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Lang;
use App\Admin;

class Login extends Controller
{

	protected $redirectTo;

	use RedirectsUsers,
		ThrottlesLogins;

	public function __construct()
	{
		$this->redirectTo = SM::smAdminSlug();
	}

	function index()
	{
		if (Auth('admins')->check())
		{
			return redirect(SM::smAdminSlug());
		} else
		{
			return view('nptl-admin/Auth/login');
		}
	}

	function login(Request $request)
	{
		$this->validate($request, [
			'email' => 'required',
			'password' => 'required'
		]);

		// If the class is using the ThrottlesLogins trait, we can automatically throttle
		// the login attempts for this application. We'll key this by the username and
		// the IP address of the client making these requests into this application.
		if ($this->hasTooManyLoginAttempts($request))
		{
			$this->fireLockoutEvent($request);

			return $this->sendLockoutResponse($request);
		}

		if ($this->attemptLogin($request))
		{
			return $this->sendLoginResponse($request);
		}

		// If the login attempt was unsuccessful we will increment the number of attempts
		// to login and redirect the user back to the login form. Of course, when this
		// user surpasses their maximum number of attempts they will get locked out.
		$this->incrementLoginAttempts($request);
		return $this->sendFailedLoginResponse($request);
	}

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */
	protected function attemptLogin(Request $request)
	{
		$admin = $this->guard();
		if (
		$admin->attempt([
			'email' => $request->input('email'),
			'password' => $request->input('password'),
			'status' => 1
		], $request->has('remember')
		)
		)
		{
			return TRUE;
		} elseif ($admin->attempt([
			'username' => $request->input('email'),
			'password' => $request->input('password'),
			'status' => 1
		], $request->has('remember')
		))
		{
			return TRUE;
		} else
		{
			return FALSE;
		}
	}

	/**
	 * Get the needed authorization credentials from the request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array
	 */
	protected function credentials(Request $request)
	{
		return $request->only($this->username(), 'password');
	}

	/**
	 * Send the response after the user was authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	protected function sendLoginResponse( Request $request ) {
		$request->session()->regenerate();
		$this->clearLoginAttempts( $request );

		if ( $request->expectsJson() ) {
			$data['username'] = Auth::user()->username;

			return $this->authenticated( $request, $this->guard()->user() ) ?: response()->json( $data, 202 );
		} else {
			return $this->authenticated( $request, $this->guard()->user() ) ?: redirect()->intended( $this->redirectPath() );
		}
	}

	/**
	 * The user has been authenticated.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function authenticated(Request $request, $user)
	{
		SM::update_user_meta($user->id, 'user_online_status', 1);
	}

	/**
	 * Get the failed login response instance.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	protected function sendFailedLoginResponse(Request $request)
	{
		return redirect()->back()
		                 ->withInput($request->only($this->username(), 'remember'))
		                 ->withErrors([
			                 $this->username() => Lang::get('auth.failed'),
		                 ]);
	}

	/**
	 * Get the login username to be used by the controller.
	 *
	 * @return string
	 */
	public function username()
	{
		return 'email';
	}

	/**
	 * Log the user out of the application.
	 *
	 * @param \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function logout(Request $request)
	{
		SM::update_user_meta(SM::current_user_id(), 'user_online_status', 0);
		SM::update_user_meta(SM::current_user_id(), 'user_last_activity', date("Y-m-d h:i:s"));

		$this->guard()->logout();

		$request->session()->flush();

		$request->session()->regenerate();

		return redirect(config('constant.smAdminSlug') . '/login')->with('s_message', 'Successfully logged out!');
	}

	/**
	 * Get the guard to be used during authentication.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard('admins');
	}

	public function check_username(Request $data)
	{
		$username = $data['username'];
		$user = Admin::where('username', $username)->first();
		if (isset($user) && count($user) > 0)
		{
			echo 1;
		} else
		{
			echo 0;
		}
	}

	public function check_email(Request $data)
	{
		$username = $data['email'];
		$user = Admin::where('email', $username)->first();
		if (isset($user) && count($user) > 0)
		{
			echo 1;
		} else
		{
			echo 0;
		}
	}

}