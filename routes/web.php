<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('index');

Auth::routes();

Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'namespace' => 'Admin',
    'middleware' => 'auth',
], function (){
    Route::get('/', 'IndexController@index')->name('index');

    Route::resources([
        'translations' => 'TranslationController',
        'languages' => 'LanguageController',
        'projects' => 'ProjectController',
        'groups' => 'GroupController',
        'users' => 'UserController'
    ]);

    Route::group([
        'prefix' => 'projects',
        'as' => 'projects.'
    ], function (){
        Route::group([
            'prefix' => 'export/{project}',
            'as' => 'export.'
        ],function(){
            Route::get('/', 'ProjectController@setUpExport')->name('show');
            Route::post('/', 'ProjectController@export')->name('file');
        });
    });
});

Route::get('/home', 'HomeController@index')->name('home');
