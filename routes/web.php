<?php

use App\Http\Controllers\UserController;
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


Route::get('add_user','UserController@addUser')->name('add.user');
Route::post('create_user','UserController@createUser')->name('create.user');
Route::delete('delete_user/{userId}','UserController@delete')->name('delete.user');
Route::get('edit_user/{userId}','UserController@editUser')->name('edit.user');
Route::post('update_user','UserController@updateUser')->name('update.user');



Route::get('/', [UserController::class, 'home'])->name('home');

Route::get('add_user', [UserController::class, 'addUser'])->name('add.user');
Route::get('create_user', [UserController::class, 'createUser'])->name('create.user');

Route::get('delete_user/{userId}', [UserController::class, 'delete'])->name('delete.user');

Route::get('edit_user/{userId}', [UserController::class, 'editUser'])->name('edit.user');
Route::get('update_user', [UserController::class, 'updateUser'])->name('update.user');