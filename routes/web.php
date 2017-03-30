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

// Route Customer Type
Route::get('/customer-type', 'CustomerTypeController@view');
Route::group(['prefix' => 'customer-type'], function () {
    Route::get('/get', 'CustomerTypeController@get');
    Route::get('/list/{option}', 'CustomerTypeController@getList');
    Route::post('/store', 'CustomerTypeController@store');
    Route::post('/update', 'CustomerTypeController@update');
    Route::post('/destroy', 'CustomerTypeController@destroy');
});

// Route Employee Type
Route::get('/employee-types', 'EmployeeTypeController@view');
Route::group(['prefix' => 'employee-types'], function () {
    Route::get('/get', 'EmployeeTypeController@get');
    Route::get('/list/{option}', 'EmployeeTypeController@getList');
    Route::post('/store', 'EmployeeTypeController@store');
    Route::post('/update', 'EmployeeTypeController@update');
    Route::post('/destroy', 'EmployeeTypeController@destroy');
});

// Route Doctor Type
Route::get('/doctor-type', 'DoctorTypeController@view');
Route::group(['prefix' => 'doctor-type'], function () {
    Route::get('/get', 'DoctorTypeController@get');
    Route::get('/list/{option}', 'DoctorTypeController@getList');
    Route::post('/store', 'DoctorTypeController@store');
    Route::post('/update', 'DoctorTypeController@update');
    Route::post('/destroy', 'DoctorTypeController@destroy');
});

// Route  Category
Route::get('/categoriess', 'CategoryController@view');
Route::group(['prefix' => 'categoriess'], function () {
    Route::get('/get', 'CategoryController@get');
    Route::get('/list/{option}', 'CategoryController@getList');
    Route::post('/store', 'CategoryController@store');
    Route::post('/update', 'CategoryController@update');
    Route::post('/destroy', 'CategoryController@destroy');
});

// Route vendor type
Route::group(['prefix' => 'vendor-type'], function () {
    Route::get('/', 'VendorTypeController@view');
    Route::get('/get', 'VendorTypeController@get');
    Route::get('/list/{option}', 'VendorTypeController@getList');
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
    Route::get('/list/{option}', 'BranchController@getList');
    //Route::post('/store', 'BranchController@store');
    //Route::post('/update', 'BranchController@update');
    //Route::post('/destroy', 'BranchController@destroy');
});

// Route country
Route::group(['prefix' => 'country'], function () {
    //Route::get('/', 'CountryController@view');
    //Route::get('/get', 'CountryController@get');
    Route::get('/list/{option}', 'CountryController@getList');
    Route::post('/store', 'CountryController@store');
    //Route::post('/update', 'CountryController@update');
    //Route::post('/destroy', 'CountryController@destroy');
});

// Route city
Route::group(['prefix' => 'city'], function () {
    //Route::get('/', 'CityController@view');
    //Route::get('/get', 'CityController@get');
    Route::get('/list/{option}', 'CityController@getList');
     Route::get('/list/{option}/{countryId}', 'CityController@getListCityByCountry');
    Route::post('/store', 'CityController@store');
    //Route::post('/update', 'CityController@update');
    //Route::post('/destroy', 'CityController@destroy');
});

// Route customer list
Route::group(['prefix' => 'customer'], function () {
    Route::get('/', 'CustomerController@view');
    Route::get('/get', 'CustomerController@get');
    Route::get('/list/{option}', 'CustomerController@getList');
    Route::post('/store', 'CustomerController@store');
    Route::post('/update', 'CustomerController@update');
    Route::post('/destroy', 'CustomerController@destroy');
});

// Route docotr list
Route::group(['prefix' => 'doctor'], function () {
    Route::get('/', 'DoctorController@view');
    Route::get('/get', 'DoctorController@get');
    Route::get('/list/{option}', 'DoctorController@getList');
    Route::post('/store', 'DoctorController@store');
    Route::post('/update', 'DoctorController@update');
    Route::post('/destroy', 'DoctorController@destroy');
});
// Route Employee list
Route::group(['prefix' => 'employee-lists'], function () {
    Route::get('/', 'EmployeeController@view');
    Route::get('/get', 'EmployeeController@get');
    Route::get('/list/{option}', 'EmployeeController@getList');
    Route::post('/store', 'EmployeeController@store');
    Route::post('/update', 'EmployeeController@update');
    Route::post('/destroy', 'EmployeeController@destroy');
});


