<?php

// Index page
Route::create('/', 'HomeController@index');

// Album
Route::create('category/{categoryName}', 'AlbumController@category');
Route::create('album/create', 'AlbumController@createAlbum');
Route::create('album/{albumId}', 'AlbumController@album');
Route::create('album/{albumId}/submitComment', 'AlbumController@comment');
Route::create('album/{albumId}/like', 'AlbumController@like');
Route::create('album/{albumId}/dislike', 'AlbumController@dislike');

// Photo
Route::create('photo/{id}', 'PhotoController@photo');
Route::create('photo/{photoId}/submitComment', 'PhotoController@comment');
Route::create('album/{albumId}/upload', 'PhotoController@upload');
Route::create('album/{albumId}/uploadSubmit', 'PhotoController@proccessUpload');

// User actions
Route::create('login', 'UserController@login');
Route::create('register', 'UserController@register');
Route::create('logout', 'UserController@logout');
Route::create('profile', 'UserController@profile');
Route::create('profile/settings', 'UserController@settings');
Route::create('user/{id}', 'AlbumController@userProfile');

// Admin
Route::create('admin', 'AdminController@adminPanel');
