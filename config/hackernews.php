<?php 

return [
    /*
    |--------------------------------------------------------------------------
    | Hackernews Url
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'url' => env('HACKERNEWS_URL', 'https://hacker-news.firebaseio.com/v0/'),

    /*
    |--------------------------------------------------------------------------
    | Limit
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'limit' => 20,

    /*
    |--------------------------------------------------------------------------
    | Api Version
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'apiversion' => 'v1',

    /*
    |--------------------------------------------------------------------------
    | Spool type
    |--------------------------------------------------------------------------
    |
    | use any of max, top, new, show, ask, job, best
    |
    */

    'spooltype' => 'max',

    /*
    |--------------------------------------------------------------------------
    | Email
    |--------------------------------------------------------------------------
    |
    | Email for output on dispatch failure
    |
    */

    'email' => 'idokoexemexamanuel3@gmail.com',
];