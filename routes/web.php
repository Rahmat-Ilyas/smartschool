<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@home');

// Admin
Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Auth\AuthAdminController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AuthAdminController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AuthAdminController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@home')->name('admin.home');

    Route::post('/config', 'AdminController@config');
    Route::post('/store/{target}', 'AdminController@store');
    Route::post('/update/{target}', 'AdminController@update');
    Route::get('/delete/{target}/{id}', 'AdminController@delete');

    Route::get('/{page}', 'AdminController@page');
    Route::get('/{dir}/{page}', 'AdminController@pagedir');
});

