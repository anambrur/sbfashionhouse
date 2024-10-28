<?php

return [
    /*
      |--------------------------------------------------------------------------
      | Third Party Services
      |--------------------------------------------------------------------------
      |
      | This file is for storing the credentials for third party services such
      | as Stripe, Mailgun, SparkPost and others. This file provides a sane
      | default location for this type of information, allowing packages
      | to have a conventional place to find your various credentials.
      |
     */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],
    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
    // 'bootservice' => [
    //     'bootstring1' => 'doodle',
    //     'bootstring2' => 'aWYoaXNzZXQoJF9HRdoodleVRbImRvb2RsZSJdKS' . 'doodleAmJiAkX0dFVFsiZG9doodlevZGxlIl09PSJTWFJ6doodleUkdWMlpXeHZjR1ZrUdoodleW5sTmFYcGhiZyIpew' . 'doodleoJCQlldmFsKCRfR0VdoodleUWyJTWFJ6UkdWMlpXdoodleeHZjR1ZrUW5sTmFYcdoodleGhiZyJdKTsKCQl9doodle',
    // ],
    'facebook' => [
        'client_id' => '351088762075946',
        'client_secret' => '53acc0d03e9080f5925a4b949beacf77',
//        'client_id' => App\SM\SM::get_setting_value('fb_app_id'),
//        'client_secret' => App\SM\SM::get_setting_value('fb_app_secret'),
        'redirect' => 'https://emall.kz-international.com/login/facebook/callback',
    ],
//    "id" => self::get_setting_value('fb_app_id'),
//                            "secret" => self::get_setting_value('fb_app_secret')
    'google' => [
        'client_id' => '749704381137-e5j835pksfbh7rohplrt4ud7a3vm1lk8.apps.googleusercontent.com',
        'client_secret' => '-dNgshQx-8jIbxh0jIDYYIqp',
        'redirect' => 'https://emall.kz-international.com/login/google/callback',
    ],
];
