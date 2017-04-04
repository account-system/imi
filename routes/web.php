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

// Route customer
Route::group(['prefix' => '/customer'], function () {
    Route::get('/', 'CustomerController@view');
    Route::get('/get', 'CustomerController@get');
    Route::post('/store', 'CustomerController@store');
    Route::post('/update', 'CustomerController@update');
    Route::post('/destroy', 'CustomerController@destroy');

    // Route customer type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'CustomerTypeController@view');
    Route::get('/get', 'CustomerTypeController@get');
    Route::get('/list/{option}', 'CustomerTypeController@getList');
    Route::post('/store', 'CustomerTypeController@store');
    Route::post('/update', 'CustomerTypeController@update');
    Route::post('/destroy', 'CustomerTypeController@destroy');
    });
});

// Route docotr list
Route::group(['prefix' => '/doctor'], function () {
    Route::get('/', 'DoctorController@view');
    Route::get('/get', 'DoctorController@get');
    Route::post('/store', 'DoctorController@store');
    Route::post('/update', 'DoctorController@update');
    Route::post('/destroy', 'DoctorController@destroy');

    // Route dector type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'DoctorTypeController@view');
    Route::get('/get', 'DoctorTypeController@get');
    Route::get('/list/{option}', 'DoctorTypeController@getList');
    Route::post('/store', 'DoctorTypeController@store');
    Route::post('/update', 'DoctorTypeController@update');
    Route::post('/destroy', 'DoctorTypeController@destroy');
    });
});

// Route Employee list
Route::group(['prefix' => 'employee'], function () {
    Route::get('/', 'EmployeeController@view');
    Route::get('/get', 'EmployeeController@get');
    Route::post('/store', 'EmployeeController@store');
    Route::post('/update', 'EmployeeController@update');
    Route::post('/destroy', 'EmployeeController@destroy');

    // Route Employee Type
    Route::group(['prefix' => 'type'], function () {
    Route::get('/', 'EmployeeTypeController@view');
    Route::get('/get', 'EmployeeTypeController@get');
    Route::get('/list/{option}', 'EmployeeTypeController@getList');
    Route::post('/store', 'EmployeeTypeController@store');
    Route::post('/update', 'EmployeeTypeController@update');
    Route::post('/destroy', 'EmployeeTypeController@destroy');
    });
});

// Route vendor
Route::group(['prefix' => '/supplier'], function () {
    Route::get('/', 'SupplierController@view');
    Route::get('/get', 'SupplierController@get');
    Route::post('/store', 'SupplierController@store');
    Route::post('/update', 'SupplierController@update');
    Route::post('/destroy', 'SupplierController@destroy');

    // Route vendor type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'SupplierTypeController@view');
    Route::get('/get', 'SupplierTypeController@get');
    Route::get('/list/{option}', 'SupplierTypeController@getList');
    Route::post('/store', 'SupplierTypeController@store');
    Route::post('/update', 'SupplierTypeController@update');
    Route::post('/destroy', 'SupplierTypeController@destroy');
    });
});

// Route product
Route::group(['prefix' => '/product'], function () {
    Route::get('/', 'ProductController@view');
    Route::get('/get', 'ProductController@get');
    Route::post('/store', 'ProductController@store');
    Route::post('/update', 'ProductController@update');
    Route::post('/destroy', 'ProductController@destroy');

    // Route product type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'ProductTypeController@view');
    Route::get('/get', 'ProductTypeController@get');
    Route::get('/list/{option}', 'ProductTypeController@getList');
    Route::post('/store', 'ProductTypeController@store');
    Route::post('/update', 'ProductTypeController@update');
    Route::post('/destroy', 'ProductTypeController@destroy');
    });
});

// Route vendor list
Route::group(['prefix' => 'branch'], function () {
    Route::get('/list/{option}', 'BranchController@getList');
});

// Route country
Route::group(['prefix' => 'country'], function () {    
    Route::get('/list/{option}', 'CountryController@getList');
    Route::post('/store', 'CountryController@store');
});

// Route city
Route::group(['prefix' => 'city'], function () {
    Route::get('/list/{option}', 'CityController@getList');
    Route::get('/list/{option}/{countryId}', 'CityController@getListCityByCountry');
    Route::post('/store', 'CityController@store');
});





