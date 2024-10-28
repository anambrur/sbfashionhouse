<?php

namespace App\Http\Controllers\Front\Auth;

use Hybridauth\Hybridauth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Mockery\Exception;
use Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use App\SM\SM;
use App\Http\Controllers\Front\Page;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
	/*
	  |--------------------------------------------------------------------------
	  | Register Controller
	  |--------------------------------------------------------------------------
	  |
	  | This controller handles the registration of new users as well as their
	  | validation and creation. By default this controller uses a trait to
	  | provide this functionality without requiring any additional code.
	  |
	 */

	use RegistersUsers;
	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application registration form.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{

		$page          = new Page();
		$data          = $page->homePageData();
		$data["title"] = "Registration";

		return view("Home", $data);
	}

	private function getPreviousUrl($profile)
	{

		$user = User::where("email", $profile->email)->first();
		if (count($user) > 0) {

			Auth::login($user);
			$url = SM::prevUrlWithExtra();
			return Redirect::to($url)->with("s_message", "Successfully logged in!");
		} else {

			$url = SM::prevUrlWithExtra("isAuthRegistration=1");
			if (preg_match('/checkout/', $url, $match)) {
				$url = url("packages?isAuthRegistration=1");
			}

			return Redirect::to($url)->with("socialAuthSuccessMessage", "Please provide your username and password to complete registration in create account section!");
		}
	}

	/**
	 * Facebook Social Registration
	 */
	public function registerWithFB()
	{

		SM::setPreviousUrl();
		$hybridauth = new Hybridauth(SM::social_config("Facebook"));
		$adapter    = $hybridauth->authenticate("Facebook");
		$profile    = $adapter->getUserProfile();
		$adapter->disconnect();

		if (count($profile) > 0) {
			var_dump($profile->email);
			exit;
			Session::put('profile', $profile);
			Session::put('provider', "fb_");
			$user = new User;
			$user->email = $profile->email;



			//                        	$validator = $this->validator( $request->all() );
			//		if ( $validator->fails() ) {
			//			if ( $request->expectsJson() ) {
			//				return response()->json( $validator->errors(), 400 );
			//			} else {
			//				return redirect( "register" )->with( "errors", $validator->errors() )->withInput();
			//			}
			//		}
			//		$validator = $this->validator( $request->all() )->validate();
			//		event( new Registered( $user = $this->create( $profile->all() ) ) );
			//
			//		$this->guard()->login( $user );
			//
			//		if ( $request->expectsJson() ) {
			//			$data['username'] = Auth::user()->username;
			//
			//			return $this->registered( $request, $user ) ?: response()->json( $data, 202 );
			//		} else {
			//			return $this->registered( $request, $user ) ?: redirect( '/login' )
			//				->with( 's_message', 'Account successfully created!<br>You may login now!' );
			//		}
			//                        
			//                
			//                



			//			return $this->getPreviousUrl( $profile );
		} else {
			$url = SM::prevUrlWithExtra("isAuthRegistration=1");

			return Redirect::to("register/facebook");
		}
	}

	/**
	 * Google Social Registration
	 */
	public function registerWithGP()
	{
		SM::setPreviousUrl();
		$hybridauth = new Hybridauth(SM::social_config("Google"));
		$adapter    = $hybridauth->authenticate("Google");
		$profile    = $adapter->getUserProfile();
		$adapter->disconnect();
		if (count($profile) > 0) {
			Session::put('profile', $profile);
			Session::put('provider', "gp_");

			return $this->getPreviousUrl($profile);
		} else {
			return Redirect::to("register/google");
		}
	}

	/**
	 * Twitter Social Registration
	 */
	public function registerWithTT()
	{
		SM::setPreviousUrl();
		$hybridauth = new Hybridauth(SM::social_config("Twitter"));
		$adapter    = $hybridauth->authenticate("Twitter");
		$profile    = $adapter->getUserProfile();
		$adapter->disconnect();
		if (count($profile) > 0) {
			Session::put('profile', $profile);
			Session::put('provider', "tt_");

			return $this->getPreviousUrl($profile);
		} else {
			return Redirect::to("register/twitter");
		}
	}

	/**
	 * Linkedin Social Registration
	 */
	public function registerWithLI()
	{
		SM::setPreviousUrl();
		$hybridauth = new Hybridauth(SM::social_config("LinkedIn"));
		$adapter    = $hybridauth->authenticate("LinkedIn");
		$profile    = $adapter->getUserProfile();
		$adapter->disconnect();
		if (count($profile) > 0) {
			Session::put('profile', $profile);
			Session::put('provider', "li_");

			return $this->getPreviousUrl($profile);
		} else {
			return Redirect::to("register/linkedin");
		}
	}

	/**
	 * Handle a registration request for the application.
	 *
	 * @param  \Illuminate\Http\Request $request
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function register(Request $request)
	{

		$validator = $this->validator($request->all());
		if ($validator->fails()) {
			if ($request->expectsJson()) {
				return response()->json($validator->errors(), 400);
			} else {
				return redirect("register")->with("errors", $validator->errors())->withInput();
			}
		}
		//		$validator = $this->validator( $request->all() )->validate();
		event(new Registered($user = $this->create($request->all())));

		$this->guard()->login($user);

		if ($request->expectsJson()) {
			$data['username'] = Auth::user()->username;

			return $this->registered($request, $user) ?: response()->json($data, 202);
		} else {
			return redirect(Session::get('smurl'));
			// 			return $this->registered( $request, $user ) ?: redirect( '/login' )
			// 				->with( 's_message', 'Account successfully created!<br>You may login now!' );
		}
	}

	public function signUpPhoneNumber(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'mobile' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 400);
		}

		$user = User::where('mobile', $request->mobile)->first();

		if ($user) {
			Auth::login($user);
			return response()->json(['redirect' => url('/home')]); // Send redirect URL
		} else {
			$user = new User();
			$user->mobile = $request->mobile;
			$user->status = 2;
			$user->save();

			$otp = rand(1111, 9999);
			$otpExpiry = now()->addMinutes(3);

			$user->otp = $otp;
			$user->otp_expiry = $otpExpiry;
			$user->save();

			$message = "Your Login OTP for Leafs E-Commerce is " . $otp . ". It will expire in 3 minutes.";
			$this->sendOtp($user->mobile, $message);

			return response()->json(['otpRequired' => true]); // Indicate OTP form should be shown
		}
	}


	public function verifyOtp(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'otp' => 'required|numeric',
			'valid_mobile' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json(['error' => $validator->errors()], 400);
		}

		$otp = $request->otp;

		$user = User::where('mobile', $request->valid_mobile)->first();
		if (!$user) {
			return response()->json(['error' => 'User not found'], 404);
		}

		if ($user->otp_expiry < now()) {
			return response()->json(['error' => 'OTP has expired'], 400);
		}

		if ($user->otp != $otp) {
			return response()->json(['error' => 'Invalid OTP'], 400);
		}

		$user->otp = null;
		$user->otp_expiry = null;
		$user->status = 1;
		$user->save();

		Auth::login($user);
		return redirect(url('/home'));
	}


	private function sendOtp($to, $message)
	{
		// dd($to, $message);
		$url = "http://139.99.39.237/api/smsapi?api_key=mPs3CslIA2tXhyrIqMip&type=text&number=$to&senderid=8809617613457&message=" . urlencode($message);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


		$smsresult = curl_exec($ch);

		// Check for cURL errors
		if (curl_errno($ch)) {
			return response()->json(['error' => 'Failed to send SMS. Error: ' . curl_error($ch)], 500);
		}

		curl_close($ch);
	}




	public function createGuestAccount($contact_email)
	{
		$data["username"] = $contact_email;
		$data["email"]    = $contact_email;
		$data["password"] = "Mizan" . rand(1, 10000000);

		while (User::where("username", $data["username"])->where("email", $data["email"])->first()) {
			$time             = time();
			$data["username"] = "guest_" . $time;
			$data["email"]    = "guest_" . $time . "@doodle-digital.com";
		}
		$user = $this->create($data);
		if (count($user) > 0) {
			if (Session::has("guest")) {
				Session::forget("guest");
				Session::save();
			}
			Auth::login($user);

			return $user;
		} else {
			return false;
		}
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array $data
	 *
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{
		return Validator::make($data, [
			'username' => 'required|max:255|unique:users',
			'email'    => 'required|email|max:255|unique:users',
			'password' => 'required|min:6|confirmed'
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array $data
	 *
	 * @return User
	 */
	protected function create(array $data)
	{
		$user = User::create([
			'username' => $data['username'],
			'email'    => $data['email'],
			'password' => bcrypt($data['password']),
			'status'   => 1
		]);

		return $user;
	}

	/**
	 * The user has been registered.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  mixed $user
	 *
	 * @return mixed
	 */
	protected function registered(Request $request, $user)
	{
		if (Session::has("profile") && count(Session::get("profile"))) {
			$data = Session::pull("profile");
			if (isset($data->photoURL) && SM::sm_string($data->photoURL)) {
				$path     = "public/" . config('constant.smUploadsDir');
				$filename = SM::sm_filename_exist($user->username . ".jpg", $path);
				$f_data   = file_get_contents($data->photoURL);

				$file = storage_path("app/" . $path . $filename);
				$fp   = fopen($file, "wb");
				if ($fp) {
					fwrite($fp, $f_data);
					fclose($fp);
					if (file_exists($file)) {
						$file_id     = SM::sm_insert_media_info(false, $filename);
						$user->image = $filename;
						$all_width   = config('constant.smImgWidth');
						$all_height  = config('constant.smImgHeight');
						SM::sm_image_resize($all_width, $all_height, storage_path("app/" . $path), $filename);
					}
				}
			}
			if (isset($data->firstName) && SM::sm_string($data->firstName)) {
				$user->firstname = $data->firstName;
			}
			if (isset($data->lastName) && SM::sm_string($data->lastName)) {
				$user->lastname = $data->lastName;
			}
			if (isset($data->identifier) && SM::sm_string($data->identifier)) {
				$user->auth_id = Session::pull("provider") . $data->identifier;
			}

			$user_id = $user->id;
			if (SM::sm_string($data->gender)) {
				$gender = $data->gender == 'male' ? '1' : '2';
				SM::update_front_user_meta($user->id, 'gender', $gender);
			}
			if (SM::sm_string($data->birthMonth) && $data->birthMonth != 0) {
				$birthday = $data->birthYear . '-' . $data->birthMonth . '-' . $data->birthDay;
				SM::update_front_user_meta($user_id, 'birthday', $birthday);
			}
			if (isset($data->address) && SM::sm_string($data->address)) {
				SM::update_front_user_meta($user_id, 'address', $data->address);
			}
			if (isset($data->country) && SM::sm_string($data->country)) {
				SM::update_front_user_meta($user_id, 'country', $data->country);
			}
			if (isset($data->city) && SM::sm_string($data->city)) {
				SM::update_front_user_meta($user_id, 'city', $data->city);
			}
			if (isset($data->zip) && SM::sm_string($data->zip)) {
				SM::update_front_user_meta($user_id, 'zip', $data->zip);
			}
			if (isset($data->description) && SM::sm_string($data->description)) {
				SM::update_front_user_meta($user_id, 'extra_note', $data->description);
			}
			$user->update();
			Session::forget("profile");
			Session::forget("provider");
			Session::regenerate();
		}
	}
}
