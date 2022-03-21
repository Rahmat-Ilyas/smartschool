<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'AdminController@home');

// Admin
Route::get('/set-sys', 'AdminController@setSysView');
Route::get('/set-sys/{id}', 'AdminController@setSys');

Route::get('/login', 'Auth\AuthController@showLoginForm')->name('login');
Route::post('/login', 'Auth\AuthController@login')->name('login.submit');
Route::get('/logout', 'Auth\AuthController@logout')->name('logout');

Route::group(['prefix' => 'admin'], function () {
    Route::get('{key}/', 'AdminController@home')->name('admin.home');

    Route::post('{key}/config', 'AdminController@config');
    Route::post('{key}/store/{target}', 'AdminController@store');
    Route::post('{key}/update/{target}', 'AdminController@update');
    Route::post('{key}/delete/{target}/{id}', 'AdminController@delete');

    Route::get('/{key}/{page}', 'AdminController@page');
    Route::get('/{key}/{dir}/{page}', 'AdminController@pagedir');
});

Route::group(['prefix' => 'user'], function () {
    Route::get('{level}/', 'UserController@home')->name('user.home');

    Route::post('{level}/config', 'UserController@config');
    Route::post('{level}/store/{target}', 'UserController@store');
    Route::post('{level}/update/{target}', 'UserController@update');
    Route::post('{level}/delete/{target}/{id}', 'UserController@delete');

    Route::get('/{level}/{page}', 'UserController@page');
    Route::get('/{level}/{dir}/{page}', 'UserController@pagedir');
});
