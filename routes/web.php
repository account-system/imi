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
	if (Auth::check()) {
    	return redirect('/dashboard');
    }else{
    	return redirect('/login');
    }
    
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

Route::get('/chart-account', 'ChartAccountController@index');

// Route Controller Customer Type
Route::get('/customer-type', 'CustomerTypeController@view');
Route::group(['prefix' => 'customer-type'], function () {
    Route::get('/get', 'CustomerTypeController@get');
    Route::get('/list', 'CustomerTypeController@lists');
    Route::post('/store', 'CustomerTypeController@store');
    Route::post('/update', 'CustomerTypeController@update');
    Route::post('/destroy', 'CustomerTypeController@destroy');
});

// Route Controller Employee Type
Route::get('/employee-types', 'EmployeeTypesController@view');
Route::group(['prefix' => 'employee-types'], function () {
    Route::get('/get', 'EmployeeTypesController@get');
    Route::get('/list', 'EmployeeTypesController@lists');
    Route::post('/store', 'EmployeeTypesController@store');
    Route::post('/update', 'EmployeeTypesController@update');
    Route::post('/destroy', 'EmployeeTypesController@destroy');
});

// Route Controller Doctor Type
Route::get('/doctor-type', 'DoctorTypesController@view');
Route::group(['prefix' => 'doctor-type'], function () {
    Route::get('/get', 'DoctorTypesController@get');
    Route::get('/list', 'DoctorTypesController@lists');
    Route::post('/store', 'DoctorTypesController@store');
    Route::post('/update', 'DoctorTypesController@update');
    Route::post('/destroy', 'DoctorTypesController@destroy');
});

// Route Controller Vendor Type
Route::get('/vendor-types', 'VendorTypesController@view');
Route::group(['prefix' => 'vendor-types'], function () {
    Route::get('/get', 'VendorTypesController@get');
    Route::get('/list', 'VendorTypesController@lists');
    Route::post('/store', 'VendorTypesController@store');
    Route::post('/update', 'VendorTypesController@update');
    Route::post('/destroy', 'VendorTypesController@destroy');
});

// Route Controller Category
Route::get('/categoriess', 'CategoriessController@view');
Route::group(['prefix' => 'categoriess'], function () {
    Route::get('/get', 'CategoriessController@get');
    Route::get('/list', 'CategoriessController@lists');
    Route::post('/store', 'CategoriessController@store');
    Route::post('/update', 'CategoriessController@update');
    Route::post('/destroy', 'CategoriessController@destroy');
});

// Route Controller Category
Route::get('/vendor-lists', 'VendorController@view');
Route::group(['prefix' => 'vendor-lists'], function () {
    Route::get('/get', 'VendorController@get');
    Route::get('/list', 'VendorController@lists');
    Route::post('/store', 'VendorController@store');
    Route::post('/update', 'VendorController@update');
    Route::post('/destroy', 'VendorController@destroy');
});