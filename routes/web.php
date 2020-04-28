<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin/associations', function() {
   return view('admin/associations');
})->name('admin.associations');
Route::get('/admin/associations/create', function() {
    return view('admin/association/create');
})->name('admin.associations.create');

Route::get('/associations', function() {
    return view('associations');
})->name('associations');

Route::get('/admin/users', function() {
    return view('admin.users');
})->name('admin.users');
Route::get('/admin/users/create', function() {
    return view('admin/user/create');
})->name('admin.users.create');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
