<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@home');

// Admin
Route::get('/set-sys', 'AdminController@setSysView');
Route::get('/set-sys/{id}', 'AdminController@setSys');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/login', 'Auth\AuthAdminController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AuthAdminController@login')->name('admin.login.submit');
    Route::get('/logout', 'Auth\AuthAdminController@logout')->name('admin.logout');
    Route::get('{key}/', 'AdminController@home')->name('admin.home');

    Route::post('{key}/config', 'AdminController@config');
    Route::post('{key}/store/{target}', 'AdminController@store');
    Route::post('{key}/update/{target}', 'AdminController@update');
    Route::post('{key}/delete/{target}/{id}', 'AdminController@delete');

    Route::get('/{key}/{page}', 'AdminController@page');
    Route::get('/{key}/{dir}/{page}', 'AdminController@pagedir');
});
