<?php
/**
 * All unauthenticated front end properties and methods
 */

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * Front end unauthenticated methods and properties
 * Class Page
 * @package App\Http\Controllers\Front
 */
class Customer extends Controller
{

    public function __construct()
    {
    }

    /**
     * Home page methods and return view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function myAccount()
    {
        return view('frontend.customer.my-account');
    }

    /**
     * Home page all data, it call from index of page, login and registration.
     * @return array
     */

}