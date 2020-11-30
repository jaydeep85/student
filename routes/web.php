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
})->name('dashboard');

Route::get('register', 'Auth\RegisterController@register')->name('register');
Route::post('register', 'Auth\RegisterController@store');


Route::get('login', 'Auth\LoginController@login')->name('login');
Route::post('login', 'Auth\LoginController@authenticate');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('forget-password', 'Auth\ForgotPasswordController@getEmail')->name('getmail');
Route::post('forget-password', 'Auth\ForgotPasswordController@postEmail')->name('sendmail');

Route::get('reset-password/{token}', 'Auth\ResetPasswordController@getPassword')->name('resetlink');
Route::post('reset-password', 'Auth\ResetPasswordController@updatePassword')->name('resetpassword');

Route::group(['middleware' => ['auth', 'preventBackHistory']], function() {
Route::get('welcome', 'StudentController@welcome')->name('welcome');

});

Route::get('admin/dashboard', 'AdminController@dashboard')->name('admin.dashboard');
Route::post('admin/login', 'AdminController@login')->name('admin.login');
Route::get('admin/logout', 'AdminController@logout')->name('admin.logout');

Route::group(['prefix' => 'admin','middleware' => ['auth.admin','preventBackHistory']], function ()
{
	Route::get('home', 'AdminController@home')->name('admin.home');
	Route::get('getAjaxStudentList', 'AjaxStudentController@index')->name('student.list');
	Route::get('ajaxStudentView/{id}', 'AjaxStudentController@view')->name('student.view');
	Route::get('ajaxStudentEdit/{id}', 'AjaxStudentController@edit')->name('student.edit');
	Route::post('ajaxStudentUpdate', 'AjaxStudentController@update')->name('student.update');
	Route::get('ajaxStudentDelete/{id}', 'AjaxStudentController@delete')->name('student.delete');
	Route::get('ajaxStudentMassDelete', 'AjaxStudentController@massDelete')->name('student.deleteall');
	

});