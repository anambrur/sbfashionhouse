<?php
/**
 * All backend routes are here.
 * User: mrksohag
 * Date: 11/13/17
 * Time: 5:23 PM
 */
Route::group(
    [
        'prefix' => config('constant.smAdminSlug'),
        'namespace' => 'Admin'
    ], function () {
    /*
     * Authentication system
     */
    Route::group(["namespace" => "Auth"], function () {
        //login
        Route::get('login', 'Login@index');
        Route::post('login', 'Login@login');
//logout
        Route::get('logout', 'Login@logout');
//register
        Route::get('register', 'Register@index');
        Route::post('register', 'Register@register');
//forgot password
        Route::get('password/reset', 'ForgotPassword@index');
        Route::post('password/reset', 'ForgotPassword@sendResetLinkEmail');
//reset password
        Route::get('password/reset/{token}', 'ResetPassword@showResetForm');
        Route::post('password/update', 'ResetPassword@reset');
//check username and email
        Route::post('check_username', 'Login@check_username');
        Route::post('check_email', 'Login@check_email');
    });


    /*
     * Admin authenticated route
     */
    Route::group(["middleware" => "admins", 'namespace' => 'Common'], function () {
        /**
         * Common Routes
         */

        /**
         * Dashboard
         */
        Route::get("/", "Dashboard@index");
        Route::get('access_denied', 'Dashboard@access_denied');
        Route::post('get_image_src', 'Dashboard@get_image_src');
        Route::post('check-slug', 'Dashboard@getSlug');
        Route::get('flush-cache', 'Dashboard@flashCache');
        Route::get('flush-session', 'Dashboard@flashSession');
        Route::get('edit_profile', 'Dashboard@edit_profile');
        Route::post('update_profile', 'Dashboard@update_profile');
        Route::get('profile', 'Dashboard@profile');
        /**
         * Search
         */
        Route::post("/customer_search", "Dashboard@searchUser");
        Route::post("/package_search", "Dashboard@searchPackage");

        /**
         * Mail
         */
        Route::post('/send-mail', 'Dashboard@offerMail')->name('offerMail');

        /**
         * Media
         */
        Route::get('media', 'Media@index');
        Route::post('media/upload', 'Media@upload');
        Route::post('media/delete', 'Media@delete');
        Route::post('media/update', 'Media@update');
        Route::get('media/download/{id}', 'Media@download');
        Route::get('media/{offset}', 'Media@getMedias');

        Route::get('media_search', 'Media@media_search')->name('media_search');

        //admin method permission check middleware
        Route::group(['middleware' => 'AdminAccess'], function () {
            /**
             * Setting
             */
            Route::group(["prefix" => "setting"], function () {
                Route::get("/", "Setting@index");
                Route::post("save_setting", "Setting@save_setting");
                Route::post("save_maintenance_setting", "Setting@save_maintenance_setting");
                Route::post("save_tax_setting", "Setting@save_tax_setting");
                Route::post("save_cache_setting", "Setting@save_cache_setting");
                Route::get("/social", "Setting@social");
                Route::post('save_meta_info', 'Setting@save_meta_info');
                Route::post('save_social', 'Setting@save_social');
                Route::post('save_fb_credential', 'Setting@save_fb_credential');
                Route::post('save_gp_credential', 'Setting@save_gp_credential');
                Route::post('save_tt_credential', 'Setting@save_tt_credential');
                Route::post('save_li_credential', 'Setting@save_li_credential');
            });
            /**
             * Coupons
             */
            Route::resource("taxes", "Taxes");
            Route::get("taxes/destroy/{id}", "Taxes@destroy");
            Route::post("taxes/tax_status_update", "Taxes@tax_status_update");
            /**
             * Shipping Methods
             */
            Route::resource("shipping_methods", "ShippingMethods");
            Route::get("shipping_methods/destroy/{id}", "ShippingMethods@destroy");
            Route::post("shipping_methods/shipping_method_status_update", "ShippingMethods@shipping_method_status_update");
            /**
             * Payment Method
             */
            Route::resource("payment_methods", "PaymentMethods");
            Route::get("payment_methods/destroy/{id}", "PaymentMethods@destroy");
            Route::post("payment_methods/payment_method_status_update", "PaymentMethods@payment_method_status_update");

            /**
             * user
             */
            Route::group(["prefix" => "users"], function () {
                Route::get('/', 'Users@index');
                Route::get('add_user', 'Users@add_user');
                Route::post('save_user', 'Users@save_user')
                    ->name("saveUser");
                Route::get('edit_user/{id}', 'Users@edit_user');
                Route::patch('update_user/{id}', 'Users@update_user')
                    ->name("updateUser");
                Route::get('delete_user/{id}', 'Users@delete_user');
                Route::post('user_status_update', 'Users@user_status_update');


                //admin user role
                Route::get('roles', 'Users@roles');
                Route::get('add_role', 'Users@add_role');
                Route::post('save_role', 'Users@save_role');
                Route::get('edit_role/{id}', 'Users@edit_role');
                Route::post('update_role', 'Users@update_role');
                Route::get('delete_role/{id}', 'Users@delete_role');
            });
            /**
             * customers
             */
            Route::group(["prefix" => "customers"], function () {
                Route::get('/', 'Customers@index');
                Route::get('/add_customer', 'Customers@add_customer');
                Route::post('/check_username', 'Customers@check_customer');
                Route::post('/check_email', 'Customers@check_email');
                Route::post('/save_customer', 'Customers@save_customer')
                    ->name("saveCustomer");
                Route::get('/edit_customer/{id}', 'Customers@edit_customer');
                Route::patch('/update_customer/{id}', 'Customers@update_customer')
                    ->name("updateCustomer");
                Route::get('/delete_customer/{id}', 'Customers@delete_customer');
                Route::post('/customer_status_update', 'Customers@customer_status_update');
            });
            /**
             * Sliders
             */
            Route::group(["prefix" => "sliders"], function () {
                Route::get('/', 'Sliders@sliders');
                Route::get('add_slider', 'Sliders@add_slider');
                Route::post('save_slider', 'Sliders@save_slider')
                    ->name("saveSlider");
                Route::get('edit_slider/{id}', 'Sliders@edit_slider');
                Route::patch('update_slider/{id}', 'Sliders@update_slider')
                    ->name("updateSlider");
                Route::get('delete_slider/{id}', 'Sliders@delete_slider');
                Route::post('slider_status_update', 'Sliders@slider_status_update');
            });

            /**
             * Appearance
             */
            Route::group(["prefix" => "appearance"], function () {
                Route::get("smthemeoptions", "Appearance@smThemeOptions");
                Route::post("save-sm-theme-options", "Appearance@saveSmThemeOptions")
                    ->name("saveThemeOption");
                Route::get('menus', 'Appearance@menus');
                Route::post('save_menus', 'Appearance@save_menus');
                /**
                 * editor
                 */
                Route::group(['prefix' => 'editor'], function () {
                    Route::any("/", "Appearance@editor");
                    Route::post("update-file", "Appearance@updateFile");
                });
            });
            /**
             * page
             */
            Route::group(["prefix" => "pages"], function () {
                Route::get('/', 'Page@index');
                Route::get('add_page', 'Page@add_page');
                Route::post('save_page', 'Page@save_page');
                Route::get('edit_page/{id}', 'Page@edit_page');
                Route::patch('update_page/{id}', 'Page@update_page');
                Route::get('delete_page/{id}', 'Page@delete_page');
                Route::post('page_status_update', 'Page@page_status_update');
            });
            /**
             * Categories
             */
            Route::resource("categories", "Categories");
            Route::get("categories/destroy/{id}", "Categories@destroy");
            Route::post("categories/category_status_update", "Categories@category_status_update");
            Route::get("dataProcessingCategory", "Categories@dataProcessingCategory")->name('dataProcessingCategory');
            /**
             * Tags
             */
            Route::resource("tags", "Tags");
            Route::get("tags/destroy/{id}", "Tags@destroy");
            Route::post("tags/tag_status_update", "Tags@tag_status_update");
            /**
             * Brands
             */
            Route::resource("brands", "Brands");
            Route::get("brands/destroy/{id}", "Brands@destroy");
            Route::post("brands/brand_status_update", "Brands@brand_status_update");
            /**
             * Attribute
             */
            Route::resource("attributetitles", "Attributetitles");
            Route::get("attributetitles/destroy/{id}", "Attributetitles@destroy");
            Route::post("attributetitles/attributetitle_status_update", "Attributetitles@attributetitle_status_update");
//            Attribute Value
            Route::get('get_attribute_data', 'Attributetitles@get_attribute_data');
            Route::post('store_attribute_data', 'Attributetitles@store_attribute_data')
                ->name('store_attribute_data');
            Route::get('edit_attribute_data', 'Attributetitles@edit_attribute_data');
            Route::post('update_attribute_data', 'Attributetitles@update_attribute_data')
                ->name('update_attribute_data');
            Route::get("delete_attribute_data/{id}", "Attributetitles@delete_attribute_data");

            /**
             * Brands
             */
            Route::resource("units", "Units");
            Route::get("units/destroy/{id}", "Units@destroy");
            Route::post("units/unit_status_update", "Units@unit_status_update");
            Route::post('unit_store', 'Units@unit_store')->name('unit_store');
            /**
             * Blogs
             */
            Route::group(["prefix" => "blogs"], function () {
                Route::get("/comments", "Blogs@comments");
                Route::get("/edit_comment/{id}", "Blogs@edit_comment");
                Route::patch("/update_comment/{id}", "Blogs@update_comment");
                Route::get("/reply_comment/{id}", "Blogs@reply_comment");
                Route::post("/save_reply", "Blogs@save_reply");
                Route::get("/delete_comment/{id}", "Blogs@delete_comment");
                Route::post("/comment_status_update", "Blogs@comment_status_update");

                Route::get("/delete/{id}", "Blogs@destroy");
                Route::post("/blog_status_update", "Blogs@blog_status_update");
            });

            Route::resource("blogs", "Blogs");

            /**
             * Products
             */
            Route::group(["prefix" => "products"], function () {
                Route::get("/reviews", "Products@reviews");
                Route::get("/export", "Products@export");
                Route::get("/importproducts", "Products@importproducts");
                Route::post("/import_csv", "Products@import_csv")->name('import_csv');

                Route::get("/edit_review/{id}", "Products@edit_review");
                Route::patch("/update_review/{id}", "Products@update_review");
                Route::get("/reply_review/{id}", "Products@reply_review");
                Route::post("/save_reply", "Products@save_reply");
                Route::get("/delete_review/{id}", "Products@delete_review");
                Route::post("/review_status_update", "Products@review_status_update");

                Route::get("/delete/{id}", "Products@destroy");
                Route::post("/blog_status_update", "Products@blog_status_update");
            });

            Route::resource("products", "Products");
            Route::get('dataProcessingProduct', 'Products@dataProcessing')
                ->name('dataProcessingProduct');
            Route::post("product_status_update", "Products@product_status_update");
            Route::get('productAttributeAddMore', 'Products@productAttributeAddMore')
                ->name('productAttributeAddMore');


            /**
             * Coupons
             */
            Route::resource("coupons", "Coupons");
            Route::get("coupons/destroy/{id}", "Coupons@destroy");
            Route::post("coupons/coupon_status_update", "Coupons@coupon_status_update");


            /**
             * orders
             */
            Route::resource("orders", "Orders");
            Route::get("orders/destroy/{id}", "Orders@destroy");
            Route::get("orders/download/{id}", "Orders@download");
            Route::post("orders/order_status_update", "Orders@order_status_update");
            Route::post("orders/order_info_update", "Orders@order_info_update")
                ->name('order_info_update');
            Route::post("orders/order_mail", "Orders@order_mail")
                ->name('order_mail');
            Route::post("orders/payment_status_update", "Orders@payment_status_update");
            Route::post("orders/payment_info_update", "Orders@payment_info_update")
                ->name('payment_info_update');


            /**
             * subscriber
             */
            Route::resource("subscribers", "Subscribers");
            Route::get("subscribers/destroy/{id}", "Subscribers@destroy");
            Route::post("subscribers/subscriber_status_update", "Subscribers@subscriber_status_update");


            /**
             * Reports
             */
            Route::group(["prefix" => "reports"], function () {
                Route::get("/orders", "Reports@orders");
            });

        });
    });
});

