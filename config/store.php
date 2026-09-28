<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Store / Brand settings
    |--------------------------------------------------------------------------
    |
    | Central place for the storefront brand name, the currency shown across
    | the site, and the administrator email address that receives order
    | notifications. Every value can be overridden from the .env file, so the
    | store can be re-branded without touching any code.
    |
    */

    'name' => env('APP_NAME', 'Ananya'),

    'tagline' => env('STORE_TAGLINE', 'Where Tradition Meets Excellence'),

    // Administrator inbox that receives a copy of every order + status email.
    'admin_email' => env('ADMIN_EMAIL', 'admin@ananya.com'),

    // "From" identity used on outgoing notification emails.
    'mail_from'      => env('MAIL_FROM_ADDRESS', 'no-reply@ananya.com'),
    'mail_from_name' => env('MAIL_FROM_NAME', 'Ananya'),

    /*
    |--------------------------------------------------------------------------
    | Currency
    |--------------------------------------------------------------------------
    |
    | "currency" is the symbol/prefix printed in front of every price on the
    | storefront, in the admin panel and in notification emails. "currency_code"
    | is the ISO code used where a code reads better than a symbol.
    |
    */

    'currency'      => env('STORE_CURRENCY', 'LKR'),
    'currency_code' => env('STORE_CURRENCY_CODE', 'LKR'),

];
