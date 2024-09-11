<?php

/*
 * This file is part of the Laravel Rave package.
 *
 * (c) templatecookie.com - Zakir Hossen <zakirsoft20@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'default_language' => env('APP_DEFAULT_LANGUAGE'),
    'timezone' => env('APP_TIMEZONE'),
    'currency' => env('APP_CURRENCY', 'USD'),
    'currency_symbol' => env('APP_CURRENCY_SYMBOL', '$'),
    'currency_symbol_position' => env('APP_CURRENCY_SYMBOL_POSITION', 'left'),

    'stripe_key' => 'xxx',
    'stripe_secret' => 'xxx',
    'stripe_webhook_secret' => 'xxx',
    'stripe_active' => false,

    'razorpay_key' => 'xxx',
    'razorpay_secret' => 'xxx',
    'razorpay_active' => false,

    'paystack_public_key' => 'xxx',
    'paystack_secret_key' => 'xxx',
    'paystack_payment_url' => 'https://api.paystack.co',
    'merchant_email' => 'applymeta6@gmail.com',
    'paystack_active' => false,

    'store_id' => '',
    'store_password' => '',
    'ssl_active' => false,
    'ssl_live_mode' => 'sandbox',

    'flw_public_key' => '',
    'flw_secret_key' => '',
    'flw_secret_hash' => '',
    'flw_active' => false,

    'im_key' => '',
    'im_secret' => '',
    'im_url' => 'https://test.instamojo.com/api/1.1/',
    'im_active' => false,

    'midtrans_merchat_id' => '',
    'midtrans_client_key' => '',
    'midtrans_server_key' => '',
    'midtrans_active' => false,

    'mollie_key' => 'test_Q9JvB3aM6e2Wkc92QjpBV3k88AF3x6',
    'mollie_active' => false,

    'paypal_sandbox_client_id' => 'xxx-2l27ANG7w3PHlzLwi2aNeyT7uCgPGTCrblg',
    'paypal_sandbox_client_secret' => 'xxx-PmAG8i46L_6YMRR1hs8O',
    'paypal_live_client_id' => '',
    'paypal_live_client_secret' => '',
    'paypal_live_mode' => 'sandbox',
    'paypal_active' => false,

    'fb_pixel' => '',
    'google_analytics' => '',

    // pusher
    'pusher_app_id' => env('PUSHER_APP_ID'),
    'pusher_app_key' => env('PUSHER_APP_KEY'),
    'pusher_app_secret' => env('PUSHER_APP_SECRET'),
    'pusher_host' => env('PUSHER_HOST'),
    'pusher_port' => env('PUSHER_PORT'),
    'pusher_schema' => env('PUSHER_SCHEME', 'https'),
    'pusher_app_cluster' => env('PUSHER_APP_CLUSTER'),

    // map show
    'map_show' => false,
];
