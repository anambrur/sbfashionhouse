<?php

namespace App\Http\Controllers\Front\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SM\SM;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Front\Page;

class ForgotPassword extends Controller {

    public function __construct() {
        $this->middleware( 'guest' );
    }

    function index() { 
        $data["title"] = "Forgot Password";

        return view( "frontend.home", $data );
    }
    function forgotPassword() {

        $data["title"] = "Forgot Password";

        return view( "frontend.common.forgotPassword", $data );
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail( Request $request ) {
        $validator = Validator::make( $request->all(), [ 'email' => 'required|email' ] );
        if ( $validator->fails() ) {
            if ( $request->expectsJson() ) {
                return response()->json( $validator->errors(), 400 );
            } else {
                return redirect( "/password/reset" )->with( "errors", $validator->errors() )->withInput();
            }
        }
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $request->only( 'email' )
        );

        if ( $response === Password::RESET_LINK_SENT ) {
            if ( $request->expectsJson() ) {
                return response()->json( [ 'status' => trans( $response ) ], 200 );
            } else {
                return redirect( "/password/reset" )
                    ->withInput()->with( 'status', trans( $response ) );
            }
        }

        // If an error was returned by the password broker, we will get this message
        // translated so we can notify a user of the problem. We'll redirect back
        // to where the users came from so they can attempt this process again.


        if ( $request->expectsJson() ) {
            return response()->json( [ 'email' => trans( $response ) ], 422 );
        } else {
            return redirect( "/password/reset" )
                ->withErrors( [
                    "email" => trans( $response ),
                ] )->withInput();
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

    protected function guard() {
        return Auth::guard();
    }

}
