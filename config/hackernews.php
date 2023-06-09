<?php 

return [
    /*
    |--------------------------------------------------------------------------
    | Hackernews Url
    |--------------------------------------------------------------------------
    |
    | This url is used to make request to the hacker news endpoint
    |
    */

    'url' => env('HACKERNEWS_URL', 'https://hacker-news.firebaseio.com/v0/'),

    /*
    |--------------------------------------------------------------------------
    | Limit
    |--------------------------------------------------------------------------
    |
    | 
    |
    */

    //'limit' => 20,

    /*
    |--------------------------------------------------------------------------
    | Api Version
    |--------------------------------------------------------------------------
    |
    | This value is the api version of your applications endpoint. 
    | the value is added as a prefix to the endpoint
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