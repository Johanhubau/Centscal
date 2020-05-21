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

Route::redirect('/', App::getLocale());

Route::prefix('{locale}')->middleware('locale')->group(function ($locale) {

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

//GENERAL ROUTES
    Route::get('/home', 'HomeController@index')->name('home');

//ASSOCIATION ROUTES
    Route::get('/associations', function () {
        return view('associations');
    })->name('associations');
    Route::get('/association/{id}', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('association/manage', ['association' => $association]);
    })->name('association.manage');

//EVENT ROUTES
    Route::get('association/{id}/event/create', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('event/create', ['association' => $association]);
    })->name('association.event.create');
    Route::get('event/{id}', function ($locale, $id) {
        $event = \App\Event::findOrFail($id);
        return view('event/update', ['event' => $event]);
    })->name('event.update');
    Route::get('association/{id}/events', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('association/events', ['association' => $association]);
    })->name('association.events');

//MATERIAL ROUTES
    Route::get('association/{id}/material/create', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('material/create', ['association' => $association]);
    })->name('association.material.create');
    Route::get('material/{id}', function ($locale, $id) {
        $material = \App\Material::findOrFail($id);
        return view('material/update', ['material' => $material]);
    })->name('material.update');

//ROOM ROUTES
    Route::get('association/{id}/room/create', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('room/create', ['association' => $association]);
    })->name('association.room.create');
    Route::get('room/{id}', function ($locale, $id) {
        $room = \App\Room::findOrFail($id);
        return view('room/update', ['room' => $room]);
    })->name('room.update');

//OCCUPATION ROUTES
    Route::get('association/{id}/occupations', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('occupation/dashboard', ['association' => $association]);
    })->name('association.occupations');

//RENT ROUTES
    Route::get('association/{id}/rents', function ($locale, $id) {
        $association = \App\Association::findOrFail($id);
        return view('rent/dashboard', ['association' => $association]);
    })->name('association.rents');

//ADMIN ASSOCIATION ROUTES
    Route::get('/admin/associations', function () {
        return view('admin/associations');
    })->name('admin.associations');
    Route::get('/admin/associations/create', function () {
        return view('admin/association/create');
    })->name('admin.associations.create');

//ADMIN USER ROUTES
    Route::get('/admin/users', function () {
        return view('admin/users');
    })->name('admin.users');
    Route::get('/admin/user/{id}/edit', function ($locale, $id) {
        $user = \App\User::findOrFail($id);
        return view('admin.users.update', ['user' => $user]);
    })->name('admin.users.update');
    Route::get('/admin/users/create', function () {
        return view('admin/user/create');
    })->name('admin.users.create');

});
