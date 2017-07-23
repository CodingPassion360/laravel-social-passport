<?php

/**
 * php artisan vendor:publish --provider="CodingPassion360\LaravelSocialPassport\Providers\SocialPassportServiceProvider"
 */

return [
    'google' => [
        'app_id' => env('GOOGLE_APP_ID', ''),
        'app_secret' => env('GOOGLE_APP_SECRET', ''),
        'app_redirect' => env('GOOGLE_APP_REDIRECT', ''),

        'create_if_not_exists' => false,
        'require_email' => true,

        'social_id_column' => 'google_id',
        'social_email_column' => 'google_email',
    ],
    'facebook' => [
        'app_id' => env('FACEBOOK_APP_ID', ''),
        'app_secret' => env('FACEBOOK_APP_SECRET', ''),

        'create_if_not_exists' => false,
        'require_email' => true,

        'social_id_column' => 'facebook_id',
        'social_email_column' => 'facebook_email'
    ],

];