<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;

use App\MasterType;
use App\CategoryList;


class ItemListController extends Controller
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
		$this->data['title'] 			= 	'Category List';

		$categoryController 			= 	new CategoryController;
		$this->data['category'] 		= 	$categoryController->getList('all')->content();

		$branchController 				= 	new BranchController;
		$this->data['branches'] 		= 	$branchController->getList('all')->content();
		
		$countryController 				= 	new CountryController;
		$this->data['countries'] 		= 	$countryController->getList('all')->content();

		$cityController					=	new cityController;
		$this->data['cities']			=	$cityController->getList('all')->content();

		return view('pages.categorys.item',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		
		$category = CategoryList::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($category);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$categorysRequest = json_decode($request->input('models'));

		foreach ($categorysRequest as $key => $categoryRequest) {
			try {

				$categoryObject = new CategoryList();

				$categoryObject->name 				= 	$categoryRequest->name;
				$categoryObject->category_type_id 	= 	$categoryRequest->category_type_id;
				$categoryObject->barcode 			= 	$categoryRequest->barcode;
				$categoryObject->stock_in 			= 	$categoryRequest->stock_in;
				$categoryObject->stock_out 			= 	$categoryRequest->stock_out;
				$categoryObject->quotity 			= 	$categoryRequest->quotity;
				$categoryObject->detail 			= 	$categoryRequest->detail;
				$categoryObject->status         	=   $categoryRequest->status;
				$categoryObject->created_by     	=   auth::id();
				$categoryObject->updated_by     	=   auth::id();

				$categoryObject->save();

				$categorysResponse[] = $categoryObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($categorysResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$categorysRequest = json_decode($request->input('models'));

		foreach ($categorysRequest as $key => $categoryRequest) {
			try {

				$categoryObject = CategoryList::findOrFail($categoryRequest->id);

				$categoryObject->name 				= 	$categoryRequest->name;
				$categoryObject->category_type_id 	= 	$categoryRequest->category_type_id;
				$categoryObject->barcode 			= 	$categoryRequest->barcode;
				$categoryObject->stock_in 			= 	$categoryRequest->stock_in;
				$categoryObject->stock_out 			= 	$categoryRequest->stock_out;
				$categoryObject->quotity 			= 	$categoryRequest->quotity;
				$categoryObject->detail 			= 	$categoryRequest->detail;
				$categoryObject->status         	=   $categoryRequest->status;
				$categoryObject->updated_by     	=   auth::id();

				$categoryObject->save();

				$categorysResponse[] = $categoryObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($categorysResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$categorysRequest = json_decode($request->input('models'));

		foreach ($categorysRequest as $key => $categoryRequest) {
			try {

				$categoryObject = CategoryList::findOrFail($categoryRequest->id);

				$categoryObject->delete();

				$categorysResponse[] = $categoryRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($categorysResponse);
	}
}
