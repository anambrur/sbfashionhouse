<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\SM\SM;
use App\Admin;
use Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class Register extends Controller
{
	/*
	  |--------------------------------------------------------------------------
	  | Register Controller for Admin
	  |--------------------------------------------------------------------------
	  |
	  | This controller handles the registration of new admin users as well as their
	  | validation and creation. By default this controller uses a trait to
	  | provide this functionality without requiring any additional code.
	  |
	 */

	use RegistersUsers;

	protected $redirectTo;

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
			return view('nptl-admin/Auth/registration');
		}
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{
		$this->validator($request->all())->validate();

		event(new Registered($user = $this->create($request->all())));

//      $this->guard()->login($user);

		return $this->registered($request, $user) ?: redirect(config('constant.smAdminSlug') . '/login')
			->with('s_message', 'Account successfully created! <br>Please wait for admin Approval!');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'username' => 'required|min:6|max:100|unique:admins',
			'email' => 'required|email|max:100|unique:admins',
			'password' => 'required|confirmed|min:6',
			'firstname' => 'required',
			'lastname' => 'required',
			'gender' => 'required',
			'terms' => 'required'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{
		$admin = Admin::create([
			'username' => $data['username'],
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
			'firstname'=>$data['firstname'],
			'lastname'=>$data['lastname']
		]);

		$admin_id = $admin->id;
		SM::update_user_meta($admin_id, 'gender', $data['gender']);
		return $admin;
	}

	/**
	 * Get the guard to be used during registration.
	 *
	 * @return \Illuminate\Contracts\Auth\StatefulGuard
	 */
	protected function guard()
	{
		return Auth::guard('admins');
	}

	/**
	 * The user has been registered.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  mixed  $user
	 * @return mixed
	 */
	protected function registered(Request $request, $user)
	{
		//
	}

}