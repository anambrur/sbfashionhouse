<?php

/**
 * -----------------------------------------------------------------------------
 * This file defined all constant
 * @author Engr. Mizanur Rahman Khan <engr.mrksohag.com>
 * @copyright (c) 2016, Engr. Mizanur Rahman Khan
 * @mofified 08-06-2017
 * -----------------------------------------------------------------------------
 */
$asset = (PHP_SAPI === 'cli') ? false : asset('/');
$site = (PHP_SAPI === 'cli') ? false : url('/');
return [
    'smSite' => $site,
//admin slug and url
    'smAdminSlug' => 'admin',
    'smAdminUrl' => $site . '/admin/',
//pagination
    'smPagination' => 10,
    'smPaginationMedia' => 49,
    'smFrontPagination' => 10,
    'cachingTimeInMinutes' => 10,
    'popupHideTimeInMinutes' => 24 * 60,
    'popupHideTimeInMinutesForSubscriber' => 30 * 24 * 60,
//image upload directory and url
    'smUploadsDir' => 'uploads/',
    'smUploads' => $asset . 'uploads/',
    'smUploadsUrl' => $asset . 'uploads/',
//image size: width and height
//1: logo
//2-4:gallery
//5:manage page
//6:manage page
//7:author small
//8-10:blog
//11-11: sliders
//12 team
//13 testimonial logo
    'smPostMaxInMb' => 5,

//galary (600x400, 112x112 not crop resized)
    'smImgWidth' => [
        30, // fav icon
        171, //header logo
        1920, //slider image
        228, //category small icon
        185, //category ad's
        430, //home page product big image
        243, //home page latest deals product image
        206, //home page product small image
        268, //category by product image
        500, //detail main product image
        1000, //detail zoom product image
        103, //detail page small product image
        297, //related product image
        75, //product sidebar special / best sale image
        265, //product sidebar on sale image
        100, //top header cart & cart page product image
        388, //compare page product image
        210, //wishlist page product image
        1017, //category main image
        369, //category header menu image
        67, //payment method image
        319, //product sidebar add image
        104, //testimonials image
        64, //footer top 6 image
        683, //featured ad's
        //        -------admin panel-----
        165,  //featured-image
        112, //media small image
        80, //lists image
        600,
        186,
    ],
    'smImgHeight' => [
        30, // fav icon
        45, //header logo
        650, //slider image
        200, //category small icon
        320, //category ad's
        450, //home page product big image
        297, //home page latest deals product image
        251, //home page product small image
        268, //category by product image
        500, //detail main product image
        1000, //detail zoom product image
        125, //detail page small product image
        297, //related product image
        75, //product sidebar special / best sale image
        313, //product sidebar on sale image
        100, //top header cart & cart page product image
        473, //compare page product image
        255, //wishlist page product image
        336, //category main image
        258, //category mheader menuimage
        32, //payment method image
        319, //product sidebar add image
        104, //testimonials image
        64, //footer top 6 image
        300, //featured ad's
        //admin panel
        165, //featured-image
        112, //media small image
        80, //lists image
        400,
        186,
    ],
    //               1    2    3    4     5   6   7    8    9    10  11  12    13   14   15   16  17

];