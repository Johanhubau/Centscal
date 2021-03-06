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

Route::prefix('/api')->middleware('auth')->group(function () {

    Route::middleware('admin')->group(function() {
        //USER ROUTES
        Route::get('/users', 'UserController@index');
        Route::post('/user', 'UserController@store');
        Route::get('/user/{user}', 'UserController@show');
        Route::post('/user/{user}', 'UserController@update');
        Route::delete('/user/{user}', 'UserController@destroy');
    });

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

//MEMBER ROUTES
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

});


Route::prefix('{locale}')->middleware(['locale'])->group(function ($locale) {

    Auth::routes();

    Route::get('/', function () {
        return view('welcome');
    })->name('welcome');

    Route::middleware('auth')->group(function () {
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

        Route::middleware('admin')->group(function () {
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

//ADMIN ASSOCIATION ROUTES
            Route::get('/admin/associations', function () {
                return view('admin/associations');
            })->name('admin.associations');
            Route::get('/admin/associations/create', function () {
                return view('admin/association/create');
            })->name('admin.associations.create');
        });
    });

});


