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
	if (Auth::check()) 
    {
    	return redirect('/dashboard');
    }else{
    	return redirect('/login');
    }    
});

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');

//Route customer
Route::group(['prefix' => '/customer'], function () {
    Route::get('/', 'CustomerController@view');
    Route::get('/get', 'CustomerController@get');
    Route::post('/store', 'CustomerController@store');
    Route::post('/update', 'CustomerController@update');
    Route::post('/destroy', 'CustomerController@destroy');

    //Route customer type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'CustomerTypeController@view');
    Route::get('/get', 'CustomerTypeController@get');
    Route::get('/list/{option}', 'CustomerTypeController@getList');
    Route::post('/store', 'CustomerTypeController@store');
    Route::post('/update', 'CustomerTypeController@update');
    Route::post('/destroy', 'CustomerTypeController@destroy');
    });

    //Route customer type
    Route::group(['prefix' => '/invoice'], function () {
    Route::get('/', 'CustomerInvoiceController@view');
    Route::get('/create', 'CustomerInvoiceController@create');
    Route::get('/list/{option}', 'CustomerInvoiceController@getList');
    Route::post('/store', 'CustomerInvoiceController@store');
    Route::post('/update', 'CustomerInvoiceController@update');
    Route::post('/destroy', 'CustomerInvoiceController@destroy');
    });
});

// Route doctor
Route::group(['prefix' => '/doctor'], function () {
    Route::get('/', 'DoctorController@view');
    Route::get('/get', 'DoctorController@get');
    Route::post('/store', 'DoctorController@store');
    Route::post('/update', 'DoctorController@update');
    Route::post('/destroy', 'DoctorController@destroy');

    //Route doctor type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'DoctorTypeController@view');
    Route::get('/get', 'DoctorTypeController@get');
    Route::get('/list/{option}', 'DoctorTypeController@getList');
    Route::post('/store', 'DoctorTypeController@store');
    Route::post('/update', 'DoctorTypeController@update');
    Route::post('/destroy', 'DoctorTypeController@destroy');
    });
});

//Route employee
Route::group(['prefix' => '/employee'], function () {
    Route::get('/', 'EmployeeController@view');
    Route::get('/get', 'EmployeeController@get');
    Route::post('/store', 'EmployeeController@store');
    Route::post('/update', 'EmployeeController@update');
    Route::post('/destroy', 'EmployeeController@destroy');

    //Route employee type
    Route::group(['prefix' => '/type'], function () {
    Route::get('/', 'EmployeeTypeController@view');
    Route::get('/get', 'EmployeeTypeController@get');
    Route::get('/list/{option}', 'EmployeeTypeController@getList');
    Route::post('/store', 'EmployeeTypeController@store');
    Route::post('/update', 'EmployeeTypeController@update');
    Route::post('/destroy', 'EmployeeTypeController@destroy');
    });
});

//Route vendor
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

//Route item
Route::group(['prefix' => '/item'], function () {
    //Route inventory
    Route::group(['prefix' => '/inventory'], function () {
    Route::get('/create', 'InventoryController@create');
    Route::post('/store', 'InventoryController@store');
    Route::get('/{id}/edit', 'InventoryController@edit');
    Route::post('/{id}/update', 'InventoryController@update');
    Route::post('/{id}/destroy', 'InventoryController@destroy');
    });

     //Route service
    Route::group(['prefix' => '/service'], function () {
    Route::get('/create', 'ServiceController@create');
    Route::post('/store', 'ServiceController@store');
    Route::get('/{id}/edit', 'ServiceController@edit');
    Route::post('/{id}/update', 'ServiceController@update');
    Route::post('/{id}/destroy', 'ServiceController@destroy');
    });

    Route::get('/create', 'ItemController@create');
    Route::get('/', 'ItemController@view');
    Route::get('/get', 'ItemController@get');
    Route::post('/store', 'ItemController@store');
    Route::post('/update', 'ItemController@update');
    Route::post('/destroy', 'ItemController@destroy');

    //Route type
    Route::group(['prefix' => '/type'], function () {
    // Route::get('/', 'ItemTypeController@view');
    // Route::get('/get', 'ItemTypeController@get');
    Route::get('/list/{option}', 'ItemTypeController@getList');
    // Route::post('/store', 'ItemTypeController@store');
    // Route::post('/update', 'ItemTypeController@update');
    // Route::post('/destroy', 'ItemTypeController@destroy');
    });

    //Route measure
    Route::group(['prefix' => '/measure'], function () {
    Route::get('/', 'MeasureController@view');
    Route::get('/list/{option}', 'MeasureController@getList');
    Route::post('/store', 'MeasureController@store');
    Route::post('/update', 'MeasureController@update');
    Route::post('/destroy', 'MeasureController@destroy');
    });

    //Route category
    Route::group(['prefix' => '/category'], function () {
    Route::get('/', 'CategoryController@view');
    Route::get('/list/{option}', 'CategoryController@getList');
    Route::post('/store', 'CategoryController@store');
    Route::post('/update', 'CategoryController@update');
    Route::post('/destroy', 'CategoryController@destroy');
    });
});

//Route branch
Route::group(['prefix' => '/branch'], function () {
    //Route::get('/', 'BranchController@view');
    //Route::get('/get', 'BranchController@get');
    Route::get('/list/{option}', 'BranchController@getList');
    //Route::post('/store', 'BranchController@store');
    //Route::post('/update', 'BranchController@update');
    //Route::post('/destroy', 'BranchController@destroy');
});

//Route country
Route::group(['prefix' => '/country'], function () {
    Route::get('/', 'CountryController@view');
    Route::get('/get', 'CountryController@get');
    Route::get('/list/{option}', 'CountryController@getList');
    Route::post('/store', 'CountryController@store');
    Route::post('/update', 'CountryController@update');
    Route::post('/destroy', 'CountryController@destroy');
});

//Route city
Route::group(['prefix' => '/city'], function () {
    //Route::get('/', 'CityController@view');
    //Route::get('/get', 'CityController@get');
    Route::get('/list/{option}', 'CityController@getList');
    Route::get('/list/{option}/{countryId}', 'CityController@getListCityByCountry');
    Route::post('/store', 'CityController@store');
    Route::post('/update', 'CityController@update');
    Route::post('/destroy', 'CityController@destroy');
});

//Route user
Route::group(['prefix' => '/user'], function () {
    Route::get('/', 'UserController@view');
    Route::get('/get/{option}', 'UserController@get');
    Route::get('/validate', 'UserController@validatorEmail');
    Route::post('/store', 'UserController@store');
    Route::post('/update', 'UserController@update');
    Route::post('/destroy', 'UserController@destroy');
    Route::post('/{id}/reset/password', 'UserController@resetPassword');
});

//Route chart of account
Route::group(['prefix' => '/account'], function(){
    Route::get('/', 'AccountController@viewAccount');
    Route::get('/get/{option}', 'AccountController@getAccountList');  
    Route::post('/store', 'AccountController@storeAccount');
    Route::post('/update', 'AccountController@updateAccount');
    Route::post('/destroy', 'AccountController@destroyAccount');
    Route::get('/validate', 'AccountController@validatorCode');
    
    //Route account type
    Route::group(['prefix' => '/type'], function () {
        Route::get('get/{option}', 'AccountController@getAccountTypeList'); 
        Route::get('{id}/account/{option}', 'AccountController@getAccountListByAccountType'); 
    });
});

//Route chart of account
Route::group(['prefix' => '/report'], function(){
    Route::group(['prefix' => '/journal'], function () {
        Route::get('/', 'ReportController@journal'); 
        Route::get('/get', 'ReportController@getJournal'); 
    });
});







