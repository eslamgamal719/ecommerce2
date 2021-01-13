<?php


use Illuminate\Support\Facades\Route;




Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {

    //login route
    Route::get('login', 'AdminAuth@login')->name('login');
    Route::post('login', 'AdminAuth@doLogin')->name('do-login');

    Route::get('forgot/password', 'AdminAuth@forgotPassword')->name('forgot.password');
    Route::post('forgot/password', 'AdminAuth@postForgotPassword')->name('post.forgot.password');
    Route::get('reset/password/{token}', 'AdminAuth@resetPassword')->name('reset.password');
    Route::post('reset/password/{token}', 'AdminAuth@postResetPassword')->name('post.reset.password');

    //group admin guard
    Route::group(['middleware' => 'admin:admin'], function() {

        //admin routes
        Route::resource('admin', 'AdminController');
        Route::delete('admin/destroy/all', 'AdminController@multi_delete');

        //users routes
        Route::resource('users', 'UserController');
        Route::delete('users/destroy/all', 'UserController@multi_delete');

        //countries routes
        Route::resource('countries', 'CountryController');
        Route::delete('countries/destroy/all', 'CountryController@multi_delete');

        //cities routes
        Route::resource('cities', 'CityController');
        Route::delete('cities/destroy/all', 'CityController@multi_delete');

        //states routes
        Route::resource('states', 'StateController');
        Route::delete('states/destroy/all', 'StateController@multi_delete');

        //trademarks routes
        Route::resource('trademarks', 'TradeMarkController');
        Route::delete('trademarks/destroy/all', 'TradeMarkController@multi_delete');

        //manufacturers routes
        Route::resource('manufacturers', 'ManufacturerController');
        Route::delete('manufacturers/destroy/all', 'ManufacturerController@multi_delete');

        //shippings routes
        Route::resource('shippings', 'ShippingController');
        Route::delete('shippings/destroy/all', 'ShippingController@multi_delete');

        //malls routes
        Route::resource('malls', 'MallController');
        Route::delete('malls/destroy/all', 'MallController@multi_delete');

        //departments routes
        Route::resource('departments', 'DepartmentController');




        Route::get('/', function() {
            return view('dashboard.home');
        })->name('admin');

        //settings routes
        Route::get('settings', 'Settings@settings');
        Route::post('settings', 'Settings@setting_save');

        Route::any('logout', 'AdminAuth@logout')->name('logout');

    });





    //make exchange between language manually
    Route::get('lang/{lang}', function($lang) {

        //reset session value
        session()->has('lang') ? session()->forget('lang') : '';

        $lang == 'ar' ? session()->put('lang', 'ar') : session()->put('lang', 'en');

        return redirect()->back();

    });

});

