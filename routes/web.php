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

Route::post('/datepicker', 'AppointmentController@makeAppointment');

Auth::routes();

Route::get('/dashboard', 'UserDashboardController@index');

Route::patch('/dashboard',  ['uses' => 'UpdateUserController@update']);

Route::get('/admin', 'PageController@adminDashboard')->name('adminDashboard');

Route::get('/history', 'PageController@appointmentHistory')->name('appointmentHistory');

Route::get('/hierarchy', 'PageController@hierarchy')->name('hierarchy');

Route::get('/levels', 'PageController@levels')->name('levels');

Route::get('/createAppointment', 'PageController@createAppointment')->name('createAppointment');

Route::get('/manageAppointments', 'PageController@manageAppointments')->name('manageAppointments');

Route::resource('options', 'OptionController');

Route::post('options/update', 'OptionController@updateHierarchy');

Route::get('options/{option}/children', 'OptionController@children');

Route::resource('appointment', 'AppointmentController');

Route::get('getFreeTimeslots', 'AppointmentController@getFreeTimeslots');

Route::post('getTicket', 'AppointmentController@getTicket');

Route::get('getTicket', 'PageController@getTicket')->name('getTicketView');

//Route::post('makeAppointment', 'AppointmentController@makeAppointment');

Route::get('getDailyAppointment', 'AppointmentController@getDailyAppointment');

Route::post('flushSlot/{id}', 'AppointmentController@flushSlot');

Route::post('storeLevels', 'OptionController@storeLevels');

Route::post('changeAppointmentState', 'AppointmentController@changeAppointmentState');

Route::get('api/getTicket', 'ApiController@getTicket');

Route::get('api/ticketStats', 'ApiController@ticketStats');

Route::post('emailTheTicket', 'AppointmentController@mailTheTicket');

Route::post('smsTheTicket', 'AppointmentController@smsTheTicket');

Route::get('/ticketsId', 'PageController@ticketsId');
