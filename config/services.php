<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // Meta (Facebook) Pixel. Events are only sent from the hosts listed here, so local and staging
    // visits never reach the ads data; elsewhere, with APP_DEBUG on, calls are logged to the console instead.
    'meta' => [
        'pixel_id' => env('META_PIXEL_ID', '1658044839300375'),
        'pixel_hosts' => array_filter(explode(',', env('META_PIXEL_HOSTS', 'mypos.pk,www.mypos.pk'))),
    ],

];
