<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'ajax',
    'as' => 'api.ajax.',
    'namespace' => 'API'
], function () {
    Route::get('translations', 'AjaxController@getTranslations')->middleware('throttle:60,1')->name('translations');
    Route::get('groups', 'AjaxController@getGroups')->middleware('throttle:60,1')->name('groups');
});
