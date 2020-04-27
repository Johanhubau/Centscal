<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//USER ROUTES
Route::get('/users', 'UserController@index');
Route::post('/user', 'UserController@store');
Route::get('/user/{user}', 'UserController@show');
Route::post('/user/{user}', 'UserController@update');
Route::delete('/user/{user}', 'UserController@destroy');

//ASSOCIATION ROUTES
Route::get('/associations', 'AssociationController@index');
Route::post('/association', 'AssociationController@store');
Route::get('/association/{association}', 'AssociationController@show');
Route::post('/association/{association}', 'AssociationController@update')->middleware('can:update,association');
Route::delete('/association/{association}', 'AssociationController@destroy')->middleware('can:delete,association');

//EVENT ROUTES
Route::get('/events', 'EventController@index');
Route::post('/event', 'EventController@store');
Route::get('/event/{event}', 'EventController@show');
Route::post('/event/{event}', 'EventController@update')->middleware('can:update,event');
Route::delete('/event/{event}', 'EventController@destroy')->middleware('can:delete,event');

//MATERIAL ROUTES
Route::get('/materials', 'MaterialController@index');
Route::post('/material', 'MaterialController@store');
Route::get('/material/{material}', 'MaterialController@show');
Route::post('/material/{material}', 'MaterialController@update')->middleware('can:update,material');
Route::delete('/material/{material}', 'MaterialController@destroy')->middleware('can:delete,material');

//MATERIAL ROUTES
Route::get('/members', 'MemberController@index');
Route::post('/member', 'MemberController@store');
Route::get('/member/{member}', 'MemberController@show');
Route::post('/member/{member}', 'MemberController@update')->middleware('can:update,member');
Route::delete('/member/{member}', 'MemberController@destroy')->middleware('can:delete,member');

//OCCUPATION ROUTES
Route::get('/occupations', 'OccupationController@index');
Route::post('/occupation', 'OccupationController@store');
Route::get('/occupation/{occupation}', 'OccupationController@show');
Route::post('/occupation/{occupation}', 'OccupationController@update')->middleware('can:update,occupation');
Route::delete('/occupation/{occupation}', 'OccupationController@destroy')->middleware('can:delete,occupation');

//OPTION ROUTES
Route::get('/options', 'OptionController@index');
Route::post('/option', 'OptionController@store');
Route::get('/option/{option}', 'OptionController@show');
Route::post('/option/{option}', 'OptionController@update')->middleware('can:update,option');
Route::delete('/option/{option}', 'OptionController@destroy')->middleware('can:delete,option');

//RENT ROUTES
Route::get('/rents', 'RentController@index');
Route::post('/rent', 'RentController@store');
Route::get('/rent/{rent}', 'RentController@show');
Route::post('/rent/{rent}', 'RentController@update')->middleware('can:update,rent');
Route::delete('/rent/{rent}', 'RentController@destroy')->middleware('can:delete,rent');

//ROOM ROUTES
Route::get('/rooms', 'RoomController@index');
Route::post('/room', 'RoomController@store');
Route::get('/room/{room}', 'RoomController@show');
Route::post('/room/{room}', 'RoomController@update')->middleware('can:update,room');
Route::delete('/room/{room}', 'RoomController@destroy')->middleware('can:delete,room');
