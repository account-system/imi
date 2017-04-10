<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CustomerTypeController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
		$this->data['title']			= 	'Customer List';

		$customerTypeController 		= 	new CustomerTypeController;
		$this->data['customerTypes'] 	= 	$customerTypeController->getList('all')->content();

		$countryController 				= 	new CountryController;
		$this->data['countries'] 		= 	$countryController->getList('all')->content();

		$cityController					= 	new CityController;
		$this->data['cities']			= 	$cityController->getList('all')->content();

		$branchController 				= 	new BranchController;
		$this->data['branches'] 		= 	$branchController->getList('all')->content();

		return view('pages.customers.customer',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$customers = Customer::all()->sortByDesc('id')->values()->all();

		return Response()->Json($customers);
	}
	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$customersRequest = json_decode($request->input('customers'));

		foreach ($customersRequest as $key => $customerRequest) {
			try {

				$customerObject = new Customer();

				$customerObject->customer_name 		= 	$customerRequest->customer_name;
				$customerObject->customer_type_id 	= 	$customerRequest->customer_type_id;
				$customerObject->gender 			= 	$customerRequest->gender;
				$customerObject->date_of_birth	 	= 	is_null($customerRequest->date_of_birth) ? 
														$customerRequest->date_of_birth : 
														new Carbon($customerRequest->date_of_birth);
				$customerObject->phone 				= 	$customerRequest->phone;
				$customerObject->email 				= 	$customerRequest->email;
				$customerObject->relative_contact 	= 	$customerRequest->relative_contact;
				$customerObject->relative_phone 	= 	$customerRequest->relative_phone;
				$customerObject->country_id 		= 	$customerRequest->country_id;
				$customerObject->city_id 			= 	$customerRequest->city_id;
				$customerObject->region 			=   $customerRequest->region;
				$customerObject->postal_code     	=   $customerRequest->postal_code;
				$customerObject->address         	=   $customerRequest->address;
				$customerObject->detail          	=   $customerRequest->detail;
				$customerObject->branch_id 			= 	$customerRequest->branch_id;
				$customerObject->status          	=   $customerRequest->status;
				$customerObject->created_by      	=   auth::id();
				$customerObject->updated_by      	=   auth::id();

				$customerObject->save();

				$customersResponse[] = $customerObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($customersResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$customersRequest = json_decode($request->input('customers'));

		foreach ($customersRequest as $key => $customerRequest) {
			try {

				$customerObject = Customer::findOrFail($customerRequest->id);
				
				$customerObject->customer_name 		= 	$customerRequest->customer_name;
				$customerObject->customer_type_id 	= 	$customerRequest->customer_type_id;
				$customerObject->gender 			= 	$customerRequest->gender;
				$customerObject->date_of_birth	 	= 	is_null($customerRequest->date_of_birth) ? 
														$customerRequest->date_of_birth : 
														new Carbon($customerRequest->date_of_birth);
				$customerObject->phone 				= 	$customerRequest->phone;
				$customerObject->email 				= 	$customerRequest->email;
				$customerObject->relative_contact 	= 	$customerRequest->relative_contact;
				$customerObject->relative_phone 	= 	$customerRequest->relative_phone;
				$customerObject->country_id 		= 	$customerRequest->country_id;
				$customerObject->city_id 			= 	$customerRequest->city_id;
				$customerObject->region 			=   $customerRequest->region;
				$customerObject->postal_code     	=   $customerRequest->postal_code;
				$customerObject->address         	=   $customerRequest->address;
				$customerObject->detail          	=   $customerRequest->detail;
				$customerObject->branch_id 			= 	$customerRequest->branch_id;
				$customerObject->status          	=   $customerRequest->status;
				$customerObject->updated_by     	=   auth::id();

				$customerObject->save();

				$customersResponse[] = $customerObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($customersResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$customersRequest = json_decode($request->input('customers'));

		foreach ($customersRequest as $key => $customerRequest) {
			try {

				$customerObject = Customer::findOrFail($customerRequest->id);

				$customerObject->delete();

				$customersResponse[] = $customerRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($customersResponse);
	}

}
