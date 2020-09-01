<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'UserController@register');
Route::post('login', 'UserController@authenticate');

Route::group(['middleware' => ['jwt.verify']], function() {

    //-------------Show user data only, no profile---------------------//
    Route::get('user', 'UserController@getUser');

    //-------------Upgrade or downgrade user to premium or free---------------------//
    Route::get('user/upgrade', 'UserController@userUpgrade');
    Route::get('user/downgrade', 'UserController@userDowngrade');

    //-------------Show user and profile data (join table user & profile)---------------------//
    Route::get('profile', 'ProfileController@getProfile');

    //-------------Save user profile---------------------//
    Route::post('profile/update', 'ProfileController@updateProfile');

    //-------------Save tracker when user click track this query---------------------//
    Route::post('tracker/query/save','TrackerController@saveQueryTracker');
    Route::post('tracker/product/save','TrackerController@saveProductTracker');

    //-------------Cancel query tracker when user click cancel this query---------------------//
    Route::post('tracker/query/cancel','TrackerController@cancelQueryTracker');
    Route::post('tracker/product/cancel','TrackerController@cancelProductTracker');

    //-------------Retrieve price data from Database---------------------//
    Route::get('price/query/list','PriceController@getQueryPrice');
    Route::get('price/product/list','PriceController@getProductPrice');
});

//-------------Save search info everytime anyone make search---------------------// || USE BY PYTHON SCRAPER
Route::post('query/save', 'QueryController@querySave');

//-------------For Python scraper to get all user saved tracker---------------------// || USE BY PYTHON SCRAPER
Route::get('tracker/query/list','TrackerController@getQueryTracker');
Route::get('tracker/product/list','TrackerController@getProductTracker');

//-------------From python scraper, save the price data to Database---------------------// || USE BY PYTHON SCRAPER
Route::post('price/query/save','PriceController@saveQueryPrice');
Route::post('price/product/save','PriceController@saveProductPrice');
