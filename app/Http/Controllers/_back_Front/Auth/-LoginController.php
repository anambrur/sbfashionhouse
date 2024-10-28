<?php

namespace App\Http\Controllers\Front\Auth;

use App\User;
use Hybridauth\Hybridauth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\SM\SM;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Lang;
use Session;
use Validator;
use App\Http\Controllers\Front\HomeController;

class LoginController extends Controller
{

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

//   use AuthenticatesUsers;

    use RedirectsUsers,
        ThrottlesLogins;

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = new HomeController();
        $data = $page->homePageData();
        $data["title"] = "Login";

        return view('frontend.home', $data);
    }

    /**
     * Login with facebook
     */
    public function loginWithFB()
    {
              
        SM::setPreviousUrl();
        $hybridauth = new Hybridauth(SM::social_config("Facebook", false));
        $adapter = $hybridauth->authenticate("Facebook");
        $profile = $adapter->getUserProfile();
        $adapter->disconnect();
        if (count($profile) > 0) {
            $id = "fb_" . $profile->identifier;
            $user = User::where("auth_id", $id)->first();
            $url = SM::prevUrlWithExtra('isAuthRegistration=1');
            if (count($user) > 0) {
                Auth::login($user);

                return redirect($url)->with("s_message", "Successfully Logged In!");
            } else {
                return redirect($url)->with("socialAuthWarningMessage", "No user Found, Please create a account to login!");
            }
        } else {
            return redirect("login/facebook");
        }
    }

    /**
     * Login with Google
     */
    public function loginWithGP()
    {
        SM::setPreviousUrl();
        $hybridauth = new Hybridauth(SM::social_config("Google", false));
        $adapter = $hybridauth->authenticate("Google");
        $profile = $adapter->getUserProfile();
        $adapter->disconnect();
        if (count($profile) > 0) {
            $id = "gp_" . $profile->identifier;
            $user = User::where("auth_id", $id)->first();
            $url = SM::prevUrlWithExtra('isAuthRegistration=1');
            if (count($user) > 0) {
                Auth::login($user);
                return redirect($url)->with("s_message", "Successfully Logged In!");
            } else {
                return redirect($url)->with("socialAuthWarningMessage", "No user Found!, Please create a account to login!");
            }
        } else {
            return redirect("login/facebook");
        }
    }

    /**
     * Login with Google
     */
    public function loginWithTT()
    {
        SM::setPreviousUrl();
        $hybridauth = new Hybridauth(SM::social_config("Twitter", false));
        $adapter = $hybridauth->authenticate("Twitter");
        $profile = $adapter->getUserProfile();
        $adapter->disconnect();
        if (count($profile) > 0) {
            $id = "tt_" . $profile->identifier;
            $user = User::where("auth_id", $id)->first();
            $url = SM::prevUrlWithExtra('isAuthRegistration=1');
            if (count($user) > 0) {
                Auth::login($user);

                return redirect($url)->with("s_message", "Successfully Logged In!");
            } else {
                return redirect($url)->with("socialAuthWarningMessage", "No user Found!, Please create a account to login!");
            }
        } else {
            return redirect("login/facebook");
        }
    }

    /**
     * Login with Google
     */
    public function loginWithLI()
    {
        SM::setPreviousUrl();
        $hybridauth = new Hybridauth(SM::social_config("LinkedIn", false));
        $adapter = $hybridauth->authenticate("LinkedIn");
        $profile = $adapter->getUserProfile();
        $adapter->disconnect();
        if (count($profile) > 0) {
            $id = "li_" . $profile->identifier;
            $user = User::where("auth_id", $id)->first();
            $url = SM::prevUrlWithExtra('isAuthRegistration=1');
            if (count($user) > 0) {
                Auth::login($user);

                return redirect($url)->with("s_message", "Successfully Logged In!");
            } else {
                return redirect($url)->with("socialAuthWarningMessage", "No user Found!, Please create a account to login!");
            }
        } else {
            return redirect("login/facebook");
        }
    }


    public function guestLogin(Request $request)
    {
        if (Session::has("smPackageUrl")) {
            echo Session::get("smPackageUrl");
            $guest = new \stdClass();
            $time = time();
            $guest->username = "guest_" . $time;
            $guest->email = "guest_" . $time . "@doodle-digital.com";
            Session::put("guest", $guest);
            Session::save();
        }
        exit();
    }

    function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json($validator->errors(), 400);
            } else {
                return redirect("login")->with("errors", $validator->errors())->withInput();
            }
        }
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        } else {
            if (Session::has('is_pending_user') && Session::get('is_pending_user') == 1) {
                if ($request->expectsJson()) {
                    return response()->json(['username' => "Please wait for Account admin Approval!"], 422);
                } else {
                    return redirect('login')->withInput()->with('s_message', 'Please wait for Account admin Approval!');
                }
            }
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = $this->guard();
        $username = $request->input('username');
        $password = $request->input('password');

        $authUsername = ['username' => $username, 'password' => $password, 'status' => 1];
        $authUsernameWS = ['username' => $username, 'password' => $password];
        $authEmail = ['email' => $username, 'password' => $password, 'status' => 1];
        $authEmailWs = ['email' => $username, 'password' => $password,];
        if ($user->attempt($authUsername, $request->has('remember'))
        ) {
            return true;
        } elseif ($user->attempt($authEmail, $request->has('remember'))
        ) {
            return true;
        } elseif ($user->attempt($authUsernameWS, $request->has('remember'))) {
            $this->logout($request);
            session(['is_pending_user' => 1]);

            return false;
        } elseif ($user->attempt($authEmailWs, $request->has('remember'))) {
            $this->logout($request);
            session(['is_pending_user' => 1]);

            return false;
        } else {
            session(['is_pending_user' => 0]);

            return false;
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();
        $this->clearLoginAttempts($request);

        if ($request->expectsJson()) {
            $data['username'] = Auth::user()->username;

            return $this->authenticated($request, $this->guard()->user()) ?: response()->json($data, 202);
        } else {
            return $this->authenticated($request, $this->guard()->user()) ?: redirect()->intended($this->redirectPath());
        }
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  mixed $user
     *
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        SM::update_front_user_meta($user->id, 'user_online_status', 1);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        if ($request->expectsJson()) {
            return response()->json([
                $this->username() => Lang::get('auth.failed'),
            ], 422);
        } else {
            return redirect("login")
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    $this->username() => Lang::get('auth.failed'),
                ]);

        }

    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            SM::update_front_user_meta($user['id'], 'front_user_online_status', 0);
            SM::update_front_user_meta($user['id'], 'front_user_last_activity', date("Y-m-d h:i:s"));
        }
        if (Session::has('profile')) {
            Session::forget('profile');
        }
        if (Session::has('smPackageUrl')) {
            Session::forget('smPackageUrl');
        }
        if (Session::has('guest')) {
            Session::forget('guest');
        }
        if (Session::has('checkout')) {
            Session::forget('checkout');
        }
//		Session::flush();
//		$this->guard()->logout();
//		$request->session()->regenerate();

        $this->guard()->logout();

        $request->session()->flush();

        $request->session()->regenerate();

        return redirect('/login')->with('s_message', 'Successfully logged Out');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

}
