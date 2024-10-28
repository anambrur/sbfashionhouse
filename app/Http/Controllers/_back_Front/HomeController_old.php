<?php

/**
 * All unauthenticated front end properties and methods
 */

namespace App\Http\Controllers\Front;

use App\Model\Common\Category;
use App\Model\Common\Payment_method;
use App\Model\Common\Product;
use App\Model\Common\Slider;
use App\Model\Common\Page as Page_model;
use App\SM\SM;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cart;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\Common\Blogs;
use App\Mail\ContactMail;
use App\Mail\ServiceMail;
use App\Mail\SubscribeMail;
use App\Model\Common\Blog;
use App\Model\Common\Cases;
use App\Model\Common\Comment;
use App\Model\Common\Like;
use App\Model\Common\Package;
use App\Model\Common\Package_detail;
use App\Model\Common\Tag;
use App\Rules\SmCustomEmail;
use App\Rules\SmCustomUrl;
use App\SM\SM_Seo_Report;
use Barryvdh\Debugbar\Middleware\Debugbar;
use GuzzleHttp\Client;
use App\Model\Common\Subscriber;
use App\Model\Common\Media;
use cookie;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use URL;
use Validator;
use Session;
use DB;
use Illuminate\Support\Facades\Input;

/**
 * Front end unauthenticated methods and properties
 * Class Page
 * @package App\Http\Controllers\Front
 */
class HomeController extends Controller {

    public function __construct() {
        
    }

    /**
     * Check customer logged in or not
     * @return integer 0=False or 1=true
     */
    public function isCustomerLoggedIn() {
        if (Auth::check()) {
            return response(1);
        } else if (Session::has("guest")) {
            return response(1);
        } else {
            if (isset($_GET['href'])) {
                $url = $_GET['href'];
                if (strpos($url, url("")) !== false) {
                    Session::put("smPackageUrl", $url);
                    Session::save();
                }
            }

            return response(0);
        }
    }

    /**
     * Home page methods and return view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $data = $this->homePageData();
        return view("frontend.home", $data);
    }

    public function homePageData() {
        $data["title"] = "Home";
        $data["is_home"] = 1;
        $key = 'homeContent';
//        sliders
        $data["sliders"] = SM::getCache('homeSlider', function () {
                    return Slider::Published()->get();
                });
        $data["latestDeals"] = SM::getCache('homelatestDealsProducts', function () {
                    $product_show = SM::smGetThemeOption("product_show", 10);
                    return Product::Published()
                                    ->latest()
                                    ->limit($product_show)
                                    ->get();
                });
        $data["categories"] = SM::getCache('categories', function () {
                    return Category::Published()
                                    ->where('parent_id', 0)
                                    ->orderBy('priority')
                                    ->get();
                });

        return $data;
    }

    function page($url) {

        $data['page'] = SM::getCache('page_' . $url, function () use ($url) {
                    return Page_model::where('slug', $url)->where('status', 1)->first();
                });
        if (isset($data['page']->id)) {
            $data['smAdminBarId'] = $data["page"]->id;
            //view increment
            $data['page']->increment('views');
            //seo data
            $data['seo_title'] = $data['page']->seo_title;
            $data['meta_key'] = $data['page']->meta_key;
            $data['meta_description'] = $data['page']->meta_description;
            $data['sidebar'] = 1;

            return view('frontend.page', $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show about page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function about($slug = null) {
        $data["pageInfo"] = SM::getCache('page_' . $slug, function () use ($slug) {
                    return Page_model::get();
                });
        if (count($data["pageInfo"]) > 0) {
            //seo data
            $data['seo_title'] = SM::smGetThemeOption("about_seo_title");
            $data['meta_description'] = SM::smGetThemeOption("about_meta_keywords");
            $data['meta_description'] = SM::smGetThemeOption("about_meta_description");

            return view("frontend.page.about", $data);
        } else {
            return abort(404);
        }
    }

    /**
     * Show faq page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faq() {
        $data['seo_title'] = SM::smGetThemeOption("faq_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("faq_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("faq_meta_description");

        return view("frontend.page.faq", $data);
    }

    /**
     * Show Team page
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function team() {
        $data['seo_title'] = SM::smGetThemeOption("team_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("team_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("team_meta_description");

        return view("frontend.page.teams", $data);
    }

    public function blog() {
        return view('frontend.page.blog');
    }

    public
            function contact() {
        $data['seo_title'] = SM::smGetThemeOption("contact_seo_title");
        $data['meta_description'] = SM::smGetThemeOption("contact_meta_keywords");
        $data['meta_description'] = SM::smGetThemeOption("contact_meta_description");

        return view("frontend.page.contact", $data);
    }

    public function send_mail(Request $request) {
        $this->validate($request, [
            "fullname" => "required|min:3|max:40",
            "email" => ["required", new SmCustomEmail],
            "subject" => "required|min:3|max:100",
            "message" => "required|min:5|max:500"
        ]);
        Mail::to(SM::get_setting_value("email"))
                ->queue(new ContactMail((object) $request->all()));
        return back()->with('s_message', 'Mail successfully send. We will contact you as soon as possible.');
//        $contact_form_success_message = SM::smGetThemeOption(
//            "contact_form_success_message", "Mail successfully send. We will contact you as soon as possible."
//        );
//        return response($contact_form_success_message, 200);
    }

    /**
     * Home page all data, it call from index of page, login and registration.
     * @return array
     */

    /**
     * Subscribe information
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function subscribe(Request $request) {
        $exitSubscribe = Subscriber::where('email', $request->email)->first();
        if (!empty($exitSubscribe)) {
            return back()->with('w_message', "You’re Already Subscribed!");
        } else {
            $this->validate($request, ['email' => 'required|email']);

            $infos = new \stdClass();
            $infos->email = $request->email;
            $infos->ip = $request->ip();

            $loc = file_get_contents('https://ipapi.co/' . $request->ip() . '/json');
            $locInfo = json_decode($loc);
            $infos->city = isset($locInfo->city) ? $locInfo->city : "";
            $infos->state = isset($locInfo->region) ? $locInfo->region : "";
            $infos->country = isset($locInfo->country_name) ? $locInfo->country_name : "";
            $subscribeMessage = SM::subscribe($infos, 0);

            $sInfo = $request->all();
            $sInfo['isAlreadySubscribed'] = $subscribeMessage['isAlreadySubscribed'];
            Mail::to($request->email)
                    ->queue(new SubscribeMail((object) $sInfo));
            return back()->with('s_message', "Thank You For Subscribing!. You're just one step away from being one of our dear susbcribers.Please check the Email provided and confirm your susbcription!");
//		return response( $subscribeMessage, 200 )
//			->cookie( 'doodleSubscriber', $infos->email, config( 'constant.popupHideTimeInMinutesForSubscriber' ) );
        }
    }

    /**
     * subscribeConfirmation
     *
     * @param $email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function subscribeConfirmation($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/')->with('w_message', 'Invalid Email');
        } else {
            $subscriber = Subscriber::where("email", $email)->first();
            if ($subscriber) {
                $subscriber->status = 1;
                $subscriber->update();

                return view("frontend.page.subscription-confirmation");
            } else {
                return redirect('/')->with('w_message', 'No Subscriber Found');
            }
        }
    }

    /**
     * Subscription closing after a cancel button press
     * @return integer
     */
    public function subscriptionClosedForADay() {
        return response(1, 200)
                        ->cookie('doodleSubscriber', "mrksohag", config('constant.popupHideTimeInMinutes'));
    }

    /**
     * Offer close after offer cancel button press
     * @return integer
     */
    public function offerClosedForADay() {
        return response(1, 200)
                        ->cookie('doodleOffer', "mrksohag", config('constant.popupHideTimeInMinutes'));
    }

    /**
     * Unsubscribe subscribed user
     *
     * @param $email
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unsubscribe($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect('/')->with('w_message', 'Invalid Email');
        } else {
            $subscriber = Subscriber::where("email", $email)->first();
            if ($subscriber) {
                $subscriber->status = 0;
                if ($subscriber->update() > 0) {
                    return redirect('/')->with('s_message', 'Successfully Unsubscribed');
                } else {
                    return redirect('/')->with('w_message', 'Unsubscriber Failed! Please contact to Admin.');
                }
            } else {
                return redirect('/')->with('w_message', 'No Subscriber Found');
            }
        }
    }

}
