<?php

namespace App\Http\Controllers;

use App\Http\Controllers\VendorTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\MasterDetail;
use App\MasterType;
use App\Employee;


class EmployeeController extends Controller
{
    /**
	 *The information we send to the view
	 *@var array
	 */
		protected $data = []; 
		
	/**
	 * Create a new employee instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function view()
	{
		$this->data['title'] = 'Employee List';

		$employeeTypeController = new EmployeeTypeController;
		$this->data['employeeTypes'] = $employeeTypeController->getList()->content();

		$branchController = new BranchController;
		$this->data['branches'] = $branchController->getList()->content();
		
		$countryController = new CountryController;
		$this->data['countries'] = $countryController->getList()->content();

		return view('pages.employee-lists',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$employee = Employee::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($employee);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$employeesRequest = json_decode($request->input('models'));

		foreach ($employeesRequest as $key => $employeeRequest) {
			try {

				$employeeObject = new Employee();

				$employeeObject->customer_type_id 	= 	$employeeRequest->customer_type_id;
				$employeeObject->name 				= 	$employeeRequest->name;
				$employeeObject->type 				= 	$employeeRequest->type;
				$employeeObject->barcode		 	= 	$employeeRequest->barcode;
				$employeeObject->sex 				= 	$employeeRequest->sex;
				$employeeObject->tel 				= 	$employeeRequest->tel;
				$employeeObject->address 			= 	$employeeRequest->address;
				$employeeObject->email 				= 	$employeeRequest->email;
				$employeeObject->status          	=   $employeeRequest->status;
				$employeeObject->created_by      	=   auth::id();
				$employeeObject->updated_by      	=   auth::id();

				$employeeObject->save();

				$employeesResponse[] = $employeeObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($employeesResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$employeesRequest = json_decode($request->input('models'));

		foreach ($employeesRequest as $key => $employeeRequest) {
			try {

				$employeeObject = Employee::findOrFail($employeeRequest->id);

				$employeeObject->customer_type_id 	= 	$employeeRequest->customer_type_id;
				$employeeObject->name 				= 	$employeeRequest->name;
				$employeeObject->type 				= 	$employeeRequest->type;
				$employeeObject->barcode		 	= 	$employeeRequest->barcode;
				$employeeObject->sex 				= 	$employeeRequest->sex;
				$employeeObject->tel 				= 	$employeeRequest->tel;
				$employeeObject->address 			= 	$employeeRequest->address;
				$employeeObject->email 				= 	$employeeRequest->email;
				$employeeObject->status          	=   $employeeRequest->status;
				$employeeObject->updated_by     	=   auth::id();

				$employeeObject->save();

				$employeesResponse[] = $employeeObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($employeesResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$employeesRequest = json_decode($request->input('models'));

		foreach ($employeesRequest as $key => $employeeRequest) {
			try {

				$employeeObject = Employee::findOrFail($employeeRequest->id);

				$employeeObject->delete();

				$employeesResponse[] = $employeeRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($employeesResponse);
	}
}
