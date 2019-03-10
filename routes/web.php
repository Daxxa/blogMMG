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
Route::resource('categories','CategoryController');
Route::get('/', 'CategoryController@index');
Route::post('commentcategory','CommentCategoryController@store')->name('commentcategory.store');
Route::resource('categories/{category}/posts','PostController');
Route::post('commentpost','CommentPostController@store')->name('commentpost.store');
Route::post('categorydestroy','CategoryController@destroy')->name('categories.destroy');


