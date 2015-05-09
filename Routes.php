<?php

Route::create('/', 'HomeController@index');
//Route::create('category/{categoryName}', 'HomeController@category');
//Route::create('category/{categoryName}/album/{albumId}', 'AlbumController@index');
Route::create('{categoryName}', 'HomeController@category');
Route::create('{categoryName}/{albumId}', 'AlbumController@index');