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

Route::get('/', 'PageController@index')->name('index');

Route::get('/datepicker', 'PageController@datePicker');

Auth::routes();

Route::get('/dashboard', 'UserDashboardController@index');

Route::patch('/dashboard',  ['uses' => 'UpdateUserController@update']);

Route::get('/admin', 'PageController@adminDashboard')->name('adminDashboard');

Route::get('/hierarchy', 'PageController@hierarchy')->name('hierarchy');

Route::get('/createAppointment', 'PageController@createAppointment')->name('createAppointment');

Route::get('/manageAppointments', 'PageController@manageAppointments')->name('manageAppointments');

Route::resource('options', 'OptionController');

Route::post('options/update', 'OptionController@updateHierarchy');

Route::get('options/{option}/children', 'OptionController@children');

Route::resource('appointment', 'AppointmentController');