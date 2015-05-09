<?php

// Index page
Route::create('/', 'HomeController@index');

// Album
Route::create('category/{categoryName}', 'AlbumController@category');
Route::create('album/create', 'AlbumController@createAlbum');
Route::create('album/{albumId}', 'AlbumController@album');

// Photo
//Route::create('photo/{id}', 'PhotoController@photo');
Route::create('album/{albumId}/upload', 'PhotoController@upload');

// User actions
Route::create('login', 'UserController@login');
Route::create('register', 'UserController@register');
Route::create('logout', 'UserController@logout');
Route::create('profile', 'UserController@profile');
Route::create('profile/settings', 'UserController@settings');
Route::create('user/{id}/albums', 'AlbumController@userAlbums');

// Admin
Route::create('admin', 'AdminController@adminPanel');
