<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class ForgotPassword extends Controller
{

	public function __construct()
	{
		$this->middleware('guest');
	}

	function index()
	{
		if (Auth('admins')->check())
		{
			return redirect(SM::smAdminSlug());
		} else
		{
			return view('nptl-admin/Auth/passwords/email');
		}
	}

	/**
	 * Send a reset link to the given user.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function sendResetLinkEmail(Request $request)
	{
		$this->validate($request, ['email' => 'required|email']);

		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.
		$response = $this->broker()->sendResetLink(
			$request->only('email')
		);

		if ($response === Password::RESET_LINK_SENT)
		{
			return back()->with('status', trans($response));
		}

		// If an error was returned by the password broker, we will get this message
		// translated so we can notify a user of the problem. We'll redirect back
		// to where the users came from so they can attempt this process again.
		return back()->withErrors(
			['email' => trans($response)]
		);
	}

	/**
	 * Get the broker to be used during password reset.
	 *
	 * @return \Illuminate\Contracts\Auth\PasswordBroker
	 */
	public function broker()
	{
		return Password::broker('admins');
	}

	protected function guard()
	{
		return Auth::guard('admins');
	}

}