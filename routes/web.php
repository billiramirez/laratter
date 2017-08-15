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

Route::get('/', 'PagesController@home');

Route::get('/messages/{message}', 'MessagesController@show');



Auth::routes();
Route::get('/auth/facebook', 'SocialAuthController@facebook');
Route::get('/auth/facebook/callback', 'SocialAuthController@callback');
Route::post('/auth/facebook/register', 'SocialAuthController@register');

Route::get('/home', 'HomeController@index');
Route::get('/messages', 'MessagesController@search');

Route::group(['middleware' => 'auth'], function (){
    Route::post('messages/create', 'MessagesController@create');
    Route::get('/conversations/{conversation}', 'UsersController@showConversation');
    Route::post('/{username}/dms','UsersController@sendPrivateMessage');
    Route::post('/{username}/follow', 'UsersController@follow');
    Route::post('/{username}/unfollow', 'UsersController@unfollow');
});


Route::get('/{username}/follows','UsersController@follows');
Route::get('/{username}/followers','UsersController@followers');

Route::get('/{username}','UsersController@show');




