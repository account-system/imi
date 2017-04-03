<?php

namespace App\Http\Controllers;

use App\Http\Controllers\EmployeeTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

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
	 * Create a new controller instance.
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
		$this->data['title'] 			= 	'Employee List';

		$employeeTypeController 		= 	new EmployeeTypeController;
		$this->data['employeeTypes'] 	= 	$employeeTypeController->getList('all')->content();

		$branchController 				= 	new BranchController;
		$this->data['branches'] 		= 	$branchController->getList('all')->content();
		
		$countryController 				= 	new CountryController;
		$this->data['countries'] 		= 	$countryController->getList('all')->content();

		$cityController					=	new cityController;
		$this->data['cities']			=	$cityController->getList('all')->content();

		return view('pages.employees.employee',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$employees = Employee::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($employees);
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

				$employeeObject->employee_type_id 	= 	$employeeRequest->employee_type_id;
				$employeeObject->name 				= 	$employeeRequest->name;
				$employeeObject->gender 			= 	$employeeRequest->gender;
				$employeeObject->identity_card		= 	$employeeRequest->identity_card;
				$employeeObject->position			= 	$employeeRequest->position;
				$employeeObject->phone 				= 	$employeeRequest->phone;
				$employeeObject->address 			= 	$employeeRequest->address;
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

				$employeeObject = new Employee();

				$employeeObject->employee_type_id 	= 	$employeeRequest->employee_type_id;
				$employeeObject->name 				= 	$employeeRequest->name;
				$employeeObject->gender 			= 	$employeeRequest->gender;
				$employeeObject->identity_card		= 	$employeeRequest->identity_card;
				$employeeObject->position			= 	$employeeRequest->position;
				$employeeObject->phone 				= 	$employeeRequest->phone;
				$employeeObject->address 			= 	$employeeRequest->address;
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
