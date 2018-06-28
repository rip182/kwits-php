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

Route::get('/home', [
  'uses' => 'HomeController@index',
  'middleware' => ['loggedIn', 'hasTravelGroup'],
])->name('home');
Route::get('/profile', 'ProfileController@myProfile');
Route::get('/friends/{friend}/activities', 'ActivitiesController@show');
Route::get('/friend-requests', 'FriendsController@friendRequests');
Route::post('/friend-requests', 'FriendsController@acceptFriendship');
Route::resource('friends', 'FriendsController');
Route::resource('expenses', 'ExpensesController');
Route::resource('payments', 'PaymentsController');
Route::resource('lendings', 'LendingsController');
Route::post('/travels', [
  'uses' => 'TravelsController@store',
  'middleware' => ['loggedIn']
]);
Route::get('/travels', [
  'uses' => 'TravelsController@index',
  'middleware' => ['loggedIn', 'hasTravelGroup']
]);
Route::get('/travels/create', [
  'uses' => 'TravelsController@create',
  'middleware' => ['loggedIn']
]);
Route::get('/travels/{id}', [
  'uses' => 'TravelsController@show',
  'middleware' => ['loggedIn', 'isMemberToTravelGroup', 'hasMembers']
]);
