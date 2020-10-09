<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Page Titles
    |--------------------------------------------------------------------------
    |
    | The page titles for every page on the site are listed here.
    |
    */
    'suffix' => 'JobScan',
    'default' => 'Login',
    'names' => [
        'App\Http\Controllers\MainController@getIndex' => 'Search Jobs',
        'App\Http\Controllers\MainController@getResults' => 'Your Job Result Search'
    ],

];
