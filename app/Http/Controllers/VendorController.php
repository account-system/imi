<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\VendorTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;

use App\MasterType;
use App\Vendor;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
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
		$this->data['title'] 		= 	'Vendor List';

		$vedorTypeController 		= 	new VendorTypeController;
		$this->data['vendorTypes'] 	= 	$vedorTypeController->getList('all')->content();

		$branchController 			= 	new BranchController;
		$this->data['branches'] 	= 	$branchController->getList('all')->content();
		
		$countryController 			= 	new CountryController;
		$this->data['countries'] 	= 	$countryController->getList('all')->content();

		$cityController				=	new cityController;
		$this->data['cities']		=	$cityController->getList('all')->content();

		return view('pages.vendor-list',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$vendors = Vendor::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($vendors);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$vendorsRequest = json_decode($request->input('models'));

		foreach ($vendorsRequest as $key => $vendorRequest) {
			try {

				$vendorObject = new Vendor();

				$vendorObject->vendor_type_id 	= 	$vendorRequest->vendor_type_id;
				$vendorObject->branch_id 		= 	$vendorRequest->branch_id;
				$vendorObject->company_name 	= 	$vendorRequest->company_name;
				$vendorObject->contact_name 	= 	$vendorRequest->contact_name;
				$vendorObject->cantact_title 	= 	$vendorRequest->cantact_title;
				$vendorObject->phone 			= 	$vendorRequest->phone;
				$vendorObject->email 			= 	$vendorRequest->email;
				$vendorObject->country_id 		= 	$vendorRequest->country_id;
				$vendorObject->city_id 			= 	$vendorRequest->city_id;
				$vendorObject->region 			=   $vendorRequest->region;
				$vendorObject->postal_code     	=   $vendorRequest->postal_code;
				$vendorObject->address         	=   $vendorRequest->address;
				$vendorObject->detail          	=   $vendorRequest->detail;
				$vendorObject->status          	=   $vendorRequest->status;
				$vendorObject->created_by      	=   auth::id();
				$vendorObject->updated_by      	=   auth::id();

				$vendorObject->save();

				$vendorsResponse[] = $vendorObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($vendorsResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$vendorsRequest = json_decode($request->input('models'));

		foreach ($vendorsRequest as $key => $vendorRequest) {
			try {

				$vendorObject = Vendor::findOrFail($vendorRequest->id);

				$vendorObject->vendor_type_id	=   $vendorRequest->vendor_type_id;
				$vendorObject->branch_id        =   $vendorRequest->branch_id;
				$vendorObject->company_name   	=   $vendorRequest->company_name;
				$vendorObject->contact_name   	=   $vendorRequest->contact_name;
				$vendorObject->cantact_title  	=   $vendorRequest->cantact_title;
				$vendorObject->phone            =   $vendorRequest->phone;
				$vendorObject->email            =   $vendorRequest->email;
				$vendorObject->country_id     	=   $vendorRequest->country_id;
				$vendorObject->city_id        	=   $vendorRequest->city_id;
				$vendorObject->region           =   $vendorRequest->region;
				$vendorObject->postal_code    	=   $vendorRequest->postal_code;
				$vendorObject->address          =   $vendorRequest->address;
				$vendorObject->detail           =   $vendorRequest->detail;
				$vendorObject->status           =   $vendorRequest->status;
				$vendorObject->updated_by     	=   auth::id();

				$vendorObject->save();

				$vendorsResponse[] = $vendorObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($vendorsResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$vendorsRequest = json_decode($request->input('models'));

		foreach ($vendorsRequest as $key => $vendorRequest) {
			try {

				$vendorObject = Vendor::findOrFail($vendorRequest->id);

				$vendorObject->delete();

				$vendorsResponse[] = $vendorRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($vendorsResponse);
	}
}
