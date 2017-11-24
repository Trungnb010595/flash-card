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
    'facebook' => [
        'client_id' => '1449317758516555',
        'client_secret' => 'c05fd832acc051b243a3e27cce9c6a75',
        'redirect' => baseSiteUrl() .'/facebook/callback'
    ],
    'google' => [
        'client_id' => '1090038866025-b5mac2j7smmkgc4id9abrtm9lp8kjghk.apps.googleusercontent.com',
        'client_secret' => 'tU8StH9-qUvoq9kF11kd4OU3',
        'redirect' => baseSiteUrl() .'/google/callback'
    ],


    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

];
