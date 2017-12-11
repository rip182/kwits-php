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
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'ProfileController@myProfile');
Route::get('/friends/{friend}/activities', 'ActivitiesController@show');
Route::get('/friend-requests', 'FriendsController@friendRequests');
Route::post('/friend-requests', 'FriendsController@acceptFriendship');
Route::resource('friends', 'FriendsController');
Route::resource('expenses', 'ExpensesController');
Route::resource('payments', 'PaymentsController');
Route::resource('lendings', 'LendingsController');
