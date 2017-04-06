<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SupplierTypeController;
use App\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class SupplierController extends Controller
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
		$this->data['title'] 		= 	'Supplier List';

		$supplierTypeController 		= 	new SupplierTypeController;
		$this->data['supplierType'] 	= 	$supplierTypeController->getList('all')->content();

		$branchController 			= 	new BranchController;
		$this->data['branches'] 	= 	$branchController->getList('all')->content();
		
		$countryController 			= 	new CountryController;
		$this->data['countries'] 	= 	$countryController->getList('all')->content();

		$cityController				=	new CityController;
		$this->data['cities']		=	$cityController->getList('all')->content();

		return view('pages.suppliers.list',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$suppliers = Supplier::all()->sortByDesc('id')->values()->all();

		return Response()->Json($suppliers);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$suppliersRequest = json_decode($request->input('models'));

		foreach ($suppliersRequest as $key => $supplierRequest) {
			try {

				$supplierObject = new Supplier();

				$supplierObject->company_name   		=   $supplierRequest->company_name;
				$supplierObject->contact_name   		=   $supplierRequest->contact_name;
				$supplierObject->contact_title  		=   $supplierRequest->contact_title;
				$supplierObject->gender 				= 	$supplierRequest->gender;
				$supplierObject->supplier_type_id		=   $supplierRequest->supplier_type_id;
				$supplierObject->phone            		=   $supplierRequest->phone;
				$supplierObject->email            		=   $supplierRequest->email;
				$supplierObject->country_id     		=   $supplierRequest->country_id;
				$supplierObject->city_id        		=   $supplierRequest->city_id;
				$supplierObject->region           		=   $supplierRequest->region;
				$supplierObject->postal_code    		=   $supplierRequest->postal_code;
				$supplierObject->address        		=   $supplierRequest->address;
				$supplierObject->detail          		=   $supplierRequest->detail;
				$supplierObject->branch_id        		=   $supplierRequest->branch_id;
				$supplierObject->status           		=   $supplierRequest->status;
				$supplierObject->created_by      		=   auth::id();
				$supplierObject->updated_by      		=   auth::id();

				$supplierObject->save();

				$suppliersResponse[] = $supplierObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($suppliersResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$suppliersRequest = json_decode($request->input('models'));

		foreach ($suppliersRequest as $key => $supplierRequest) {
			try {

				$supplierObject = Supplier::findOrFail($supplierRequest->id);

				$supplierObject->company_name   		=   $supplierRequest->company_name;
				$supplierObject->contact_name   		=   $supplierRequest->contact_name;
				$supplierObject->contact_title  		=   $supplierRequest->contact_title;
				$supplierObject->gender 				= 	$supplierRequest->gender;
				$supplierObject->supplier_type_id		=   $supplierRequest->supplier_type_id;
				$supplierObject->phone            		=   $supplierRequest->phone;
				$supplierObject->email            		=   $supplierRequest->email;
				$supplierObject->country_id     		=   $supplierRequest->country_id;
				$supplierObject->city_id        		=   $supplierRequest->city_id;
				$supplierObject->region           		=   $supplierRequest->region;
				$supplierObject->postal_code    		=   $supplierRequest->postal_code;
				$supplierObject->address          		=   $supplierRequest->address;
				$supplierObject->detail          		=   $supplierRequest->detail;
				$supplierObject->branch_id        		=   $supplierRequest->branch_id;
				$supplierObject->status           		=   $supplierRequest->status;
				$supplierObject->updated_by     		=   auth::id();

				$supplierObject->save();

				$suppliersResponse[] = $supplierObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($suppliersResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$suppliersRequest = json_decode($request->input('models'));

		foreach ($suppliersRequest as $key => $supplierRequest) {
			try {

				$supplierObject = Supplier::findOrFail($supplierRequest->id);

				$supplierObject->delete();

				$suppliersResponse[] = $supplierRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($suppliersResponse);
	}
}
