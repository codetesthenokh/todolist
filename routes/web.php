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
Route::get('/home', "HomeController@index")->name('home');

Route::middleware('checkSession')->group( function() {
    Route::get('/', "ToDoListController@index")->name('to_do_list');
    Route::get('/todolist/create', "ToDoListController@addToDoList")->name('new_to_do_list');
    Route::post('/todolist/create', "ToDoListController@addToDoList")->name('create_to_do_list');
    Route::get('/todolist/edit/{id}', "ToDoListController@editToDoList")->name('edit_to_do_list');
    Route::post('/todolist/edit/{id}', "ToDoListController@saveToDoList")->name('save_to_do_list');
    Route::get('/todolist/setcomplete/{id}', "ToDoListController@setToDoListComplete")->name('set_complete_to_do_list');
    Route::get('/account/changepassword', "UserController@changePassword")->name('change_password');
    Route::post('/account/changepassword', "UserController@changePassword")->name('submit_change_password');
    Route::get('/account/profile', "UserController@editProfile")->name('edit_profile');
    Route::post('/account/profile', "UserController@saveProfile")->name('submit_edit_profile');
});

Route::get('/account/register', "UserController@register")->name('register');
Route::post('/account/register', "UserController@register")->name('create_account');
Route::get('/login', "UserController@login")->name('login');
Route::post('/login', "UserController@login")->name('login_auth');

Route::post('/logout', "UserController@logout")->name('logout');

Route::get('errors/404', function() {
    return view('errors/404');
})->name('not found');
