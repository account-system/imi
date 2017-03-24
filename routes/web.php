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

// Route Controller Category
Route::get('/categoriess', 'CategoriessController@view');
Route::group(['prefix' => 'categoriess'], function () {
    Route::get('/get', 'CategoriessController@get');
    Route::get('/list', 'CategoriessController@lists');
    Route::post('/store', 'CategoriessController@store');
    Route::post('/update', 'CategoriessController@update');
    Route::post('/destroy', 'CategoriessController@destroy');
});

// Route vendor type
Route::group(['prefix' => 'vendor-type'], function () {
    Route::get('/', 'VendorTypeController@view');
    Route::get('/get', 'VendorTypeController@get');
    Route::get('/list', 'VendorTypeController@getList');
    Route::post('/store', 'VendorTypeController@store');
    Route::post('/update', 'VendorTypeController@update');
    Route::post('/destroy', 'VendorTypeController@destroy');
});
// Route vendor list
Route::group(['prefix' => 'vendor-list'], function () {
    Route::get('/', 'VendorController@view');
    Route::get('/get', 'VendorController@get');
    Route::post('/store', 'VendorController@store');
    Route::post('/update', 'VendorController@update');
    Route::post('/destroy', 'VendorController@destroy');
});

// Route vendor list
Route::group(['prefix' => 'branch'], function () {
    //Route::get('/', 'BranchController@view');
    //Route::get('/get', 'BranchController@get');
    Route::get('/list', 'BranchController@getList');
    Route::get('/list-foreign-key-column', 'BranchController@getForeignKeyColumn');
    //Route::post('/store', 'BranchController@store');
    //Route::post('/update', 'BranchController@update');
    //Route::post('/destroy', 'BranchController@destroy');
});

// Route country
Route::group(['prefix' => 'country'], function () {
    //Route::get('/', 'CountryController@view');
    //Route::get('/get', 'CountryController@get');
    Route::get('/list', 'CountryController@getList');
    Route::post('/store', 'CountryController@store');
    //Route::post('/update', 'CountryController@update');
    //Route::post('/destroy', 'CountryController@destroy');
});
