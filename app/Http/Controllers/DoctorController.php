<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Controllers\DoctorTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;
use Carbon\Carbon;
use App\MasterType;
use App\Doctor;

class DoctorController extends Controller
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
		$this->data['title'] = 'Doctor List';

		$doctorTypeController 			= new DoctorTypeController;
		$this->data['doctorTypes'] 		= $doctorTypeController->getList('all')->content();

		$branchController 				= new BranchController;
		$this->data['branches'] 		= $branchController->getList('all')->content();
		
		$countryController 				= new CountryController;
		$this->data['countries'] 		= $countryController->getList('all')->content();

		$cityController					= new cityController;
		$this->data['cities']			= $cityController->getList('all')->content();

		return view('pages.doctor',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$doctor = Doctor::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($doctor);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$doctorsRequest = json_decode($request->input('models'));

		foreach ($doctorsRequest as $key => $doctorRequest) {
			try {

				$doctorObject = new Doctor();

				$doctorObject->first_name 			= 	$doctorRequest->first_name;
				$doctorObject->last_name 			= 	$doctorRequest->last_name;
				$doctorObject->job_title 			= 	$doctorRequest->job_title;
				$doctorObject->gender 				= 	$doctorRequest->gender;
				$doctorObject->date_of_birth	 	= 	new Carbon($doctorRequest->date_of_birth);
				$doctorObject->doctor_type_id 		= 	$doctorRequest->doctor_type_id;
				$doctorObject->branch_id 			= 	$doctorRequest->branch_id;
				$doctorObject->phone 				= 	$doctorRequest->phone;
				$doctorObject->email 				= 	$doctorRequest->email;
				$doctorObject->country_id 			= 	$doctorRequest->country_id;
				$doctorObject->city_id 				= 	$doctorRequest->city_id;
				$doctorObject->region 				=   $doctorRequest->region;
				$doctorObject->postal_code     		=   $doctorRequest->postal_code;
				$doctorObject->address         		=   $doctorRequest->address;
				$doctorObject->detail          		=   $doctorRequest->detail;
				$doctorObject->status          		=   $doctorRequest->status;
				$doctorObject->created_by      		=   auth::id();
				$doctorObject->updated_by      		=   auth::id();

				$doctorObject->save();

				$doctorsResponse[] = $doctorObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($doctorsResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$doctorsRequest = json_decode($request->input('models'));

		foreach ($doctorsRequest as $key => $doctorRequest) {
			try {

				$doctorObject = Doctor::findOrFail($doctorRequest->id);

				$doctorObject->first_name 			= 	$doctorRequest->first_name;
				$doctorObject->last_name 			= 	$doctorRequest->last_name;
				$doctorObject->job_title 			= 	$doctorRequest->job_title;
				$doctorObject->gender 				= 	$doctorRequest->gender;
				$doctorObject->date_of_birth	 	= 	new Carbon($doctorRequest->date_of_birth);
				$doctorObject->doctor_type_id 		= 	$doctorRequest->doctor_type_id;
				$doctorObject->branch_id 			= 	$doctorRequest->branch_id;
				$doctorObject->phone 				= 	$doctorRequest->phone;
				$doctorObject->email 				= 	$doctorRequest->email;
				$doctorObject->country_id 			= 	$doctorRequest->country_id;
				$doctorObject->city_id 				= 	$doctorRequest->city_id;
				$doctorObject->region 				=   $doctorRequest->region;
				$doctorObject->postal_code     		=   $doctorRequest->postal_code;
				$doctorObject->address         		=   $doctorRequest->address;
				$doctorObject->detail          		=   $doctorRequest->detail;
				$doctorObject->status          		=   $doctorRequest->status;
				$doctorObject->updated_by     		=   auth::id();

				$doctorObject->save();

				$doctorsResponse[] = $doctorObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($doctorsResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$doctorsRequest = json_decode($request->input('models'));

		foreach ($doctorsRequest as $key => $doctorRequest) {
			try {

				$doctorObject = Doctor::findOrFail($doctorRequest->id);

				$doctorObject->delete();

				$doctorsResponse[] = $doctorRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($doctorsResponse);
	}

}
