<?php


//Auth::routes();
// Route::get('/clear-cache', function () {
//     $exitCode = Artisan::call('config:clear');
//     $exitCode = Artisan::call('cache:clear');
//     $exitCode = Artisan::call('config:cache');
//     return 'DONE'; //Return anything
// });


Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'DONE'; //Return anything
});

Route::get("is-customer-logged-in", "Front\HomeController@isCustomerLoggedIn");
Route::group(["namespace" => "Front\Auth"], function () {
    Route::post("guest-login", "LoginController@guestLogin");
    Route::get('login/{social}', 'LoginController@socialLogin');
    Route::get('login/{social}/callback', 'LoginController@handleSocialLoginCallback');



    // Route::get("login", "LoginController@index");
    Route::get("signin", "LoginController@index");
    Route::get("logout", "LoginController@logout");
    Route::post("login", "LoginController@login")->name("login");
    Route::get("login", "LoginController@loginInform");
    Route::get("register", "RegisterController@index");
    Route::get("signup", "RegisterController@index");
    Route::post("register", "RegisterController@register");
    Route::post("signUpPhoneNumber", "RegisterController@signUpPhoneNumber");
    // Route::post("verifyOtp", "LoginController@verifyOtp");
    Route::post("verifyOtp", "RegisterController@verifyOtp");
    Route::get('password/reset', 'ForgotPassword@index');
    Route::post('password/reset', 'ForgotPassword@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'ResetPassword@showResetForm')->name('password.reset');
    Route::post('password/update', 'ResetPassword@reset');
    Route::get('forgot-password', 'ForgotPassword@forgotPassword');


    /**
     * social login and registration
     */
    //login and register with fb
    //    Route::get('login/facebook/{auth?}', 'LoginController@loginWithFB');
    //    Route::get('register/facebook', 'RegisterController@registerWithFB');
    //login and register with gp
    Route::get('login/google', 'LoginController@loginWithGP');
    Route::get('register/google', 'RegisterController@registerWithGP');
    //login and register with twitter
    Route::get('login/twitter', 'LoginController@loginWithTT');
    Route::get('register/twitter', 'RegisterController@registerWithTT');
    //login and register with linkedin
    Route::get('login/linkedin', 'LoginController@loginWithLI');
    Route::get('register/linkedin', 'RegisterController@registerWithLI');
});
/**
 * Fronend Pages
 */
Route::group(["namespace" => "Front"], function () {

    Route::get('/', 'HomeController@index');
    Route::get('/home', "HomeController@index")->name('home');
    Route::get('page/{url?}', 'HomeController@page');
    Route::get('/blog', 'HomeController@blog');
    Route::get('/about', 'HomeController@about');
    Route::get('/contact', 'HomeController@contact');
    Route::post('/send_mail', "HomeController@send_mail");
    Route::get('/seoScore', "HomeController@seoScore");
    Route::post('/subscribe', "HomeController@subscribe");
    //    categoryType_filter_by_product
    Route::post('main_search', 'ProductController@main_search');
    Route::get('categoryType_filter_by_product', 'ProductController@categoryType_filter_by_product')
        ->name('categoryType_filter_by_product');
    //shop
    Route::get('/shop/', 'ProductController@shop')->name('shop');
    Route::get('/product/', 'ProductController@shop')->name('product');
    Route::get('/category/', 'ProductController@shop')->name('category');
    Route::get('product_search_data', 'ProductController@product_search_data')
        ->name('product_search_data');
    Route::get('/product/{slug}/', 'ProductController@productDetail');
    Route::get('/category/{slug}/', 'ProductController@categoryByProduct');
    Route::get('/tag/{slug}', "ProductController@tagByProduct");
    Route::get('product_color_by_size', 'ProductController@product_color_by_size')
        ->name('product_color_by_size');
    Route::get('product_size_by_color', 'ProductController@product_size_by_color')
        ->name('product_size_by_color');
    //    review
    Route::get('add_to_review', 'CartController@add_to_review')->name('add_to_review');
    Route::get('remove_to_review', 'CartController@remove_to_review')->name('remove_to_review');

    //Wishlist--------------
    Route::get('add_to_wishlist', 'CartController@add_to_wishlist')->name('add_to_wishlist');
    Route::get('remove_to_wishlist', 'CartController@remove_to_wishlist')->name('remove_to_wishlist');
    //    add-to-cart
    Route::get('add-to-cart', 'CartController@add_to_cart')->name('add_to_cart');
    Route::get('cart', 'CartController@cart');
    Route::get('remove_to_cart', 'CartController@remove_to_cart')->name('remove_to_cart');
    Route::get('destroy_to_cart', 'CartController@destroy_to_cart')->name('destroy_to_cart');
    Route::get('update_to_cart', 'CartController@update_to_cart')->name('update_to_cart');
    /**
     * Customer Compare Management
     */
    Route::get("/compare", "CartController@compare");
    Route::get('add_to_compare', 'CartController@add_to_compare')->name('add_to_compare');
    Route::get('remove_to_compare', 'CartController@remove_to_compare')->name('remove_to_compare');
    /**
     * subscribe Management
     */
    Route::post('/subscribe', "HomeController@subscribe");
    Route::get('/unsubscribe/{email}', "HomeController@unsubscribe");
    Route::get('/subscribe-confirmation/{email}', "HomeController@subscribeConfirmation");
    Route::get('/subscription-close-for-a-day', "HomeController@subscriptionClosedForADay");

    //    ---------------------------
    Route::get('viewcart', 'CheckoutController@viewcart');

    //this is direct confirm order using phone number
    Route::post('confirm-order', 'CheckoutController@confirmOrder');
    Route::post('check-authentication', 'CheckoutController@checkAuthentication')->name('check.authentication');
    Route::post('verify-otp', 'CheckoutController@verifyOtp')->name('verify.otp');


    Route::group(['middleware' => 'CheckoutAccess'], function () {
        Route::get('checkout', 'CheckoutController@checkout');
        Route::get('order-fail', 'CheckoutController@orderFail');

        

        Route::post('easypaywaySuccess', 'CheckoutController@easypaywaySuccess')->name('easypaywaySuccess');
        Route::post('checkout_shipping_address', 'CheckoutController@checkout_shipping_address');
        Route::post('checkout_billing_address', 'CheckoutController@checkout_billing_address');
        Route::post('checkout_shipping_method', 'CheckoutController@checkout_shipping_method');
        Route::get('coupon-check', 'CheckoutController@couponCheck')->name('coupon_check');
        Route::post('place_order', 'CheckoutController@placeOrder');
        Route::get('order-success', 'CheckoutController@orderSuccess');
        Route::get('order-fail', 'CheckoutController@orderFail');
    });
});
/**
 * Customer Dashboard
 */
Route::group(['middleware' => 'auth', 'namespace' => 'Front', 'prefix' => 'dashboard'], function () {
    Route::get("/", "Dashboard@index");
    Route::get("/edit-profile", "Dashboard@editProfile");
    Route::post("/save-profile", "Dashboard@saveProfile");
    Route::post("/user-profile-pic-change", "Dashboard@saveProfilePicture");
    Route::post("/update-password", "Dashboard@updatePassword");
    Route::get("/downloads", "Dashboard@downloads");
    Route::get("/media/download/{id}", "Dashboard@mediaDownload");
    /**
     * Customer Order Management
     */
    Route::group(['prefix' => 'orders'], function () {
        Route::get("/", "Dashboard@orders");
        Route::get("/status/{status}", "Dashboard@orders");
        Route::get("/detail/{id}", "Dashboard@detailOrders");
        //        Route::get("/reorder/{id}", "Checkout@reorder");
        Route::get("/edit/{id}", "Dashboard@editOrders");
        Route::get("/download/{id}", "Dashboard@downloadOrders");
        Route::get("/pay/{id}", "Checkout@pay");
        Route::post('/pay-due', 'Checkout@payDue');
    });
    /**
     * Customer wishlist Management
     */
    Route::group(['prefix' => 'wishlist'], function () {
        Route::get("/", "Dashboard@wishlist");
    });
    Route::group(['prefix' => 'review'], function () {
        Route::get("/", "Dashboard@review");
    });

    /**
     * Customer support system
     */
});
