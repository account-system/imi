<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CountryController;

use App\MasterType;
use App\Product;

class ProductController extends Controller
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
		$this->data['title'] 			= 	'supplier List';

		$productTypesController 		= 	new ProductTypeController;
		$this->data['productTypes'] 	= 	$productTypesController->getList('all')->content();

		$branchController 				= 	new BranchController;
		$this->data['branches'] 		= 	$branchController->getList('all')->content();
		
		$countryController 				= 	new CountryController;
		$this->data['countries'] 		= 	$countryController->getList('all')->content();

		$cityController					=	new cityController;
		$this->data['cities']			=	$cityController->getList('all')->content();

		return view('pages.products.list',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$products = Product::all()->sortByDesc('created_at')->values()->all();

		return Response()->Json($products);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$productsRequest = json_decode($request->input('models'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = new Product();

				$productObject->name 		  		=   $productRequest->name;
				$productObject->product_type_id		=   $productRequest->product_type_id;
				$productObject->barcode        		=   $productRequest->barcode;
				$productObject->price_in            =   $productRequest->price_in;
				$productObject->price_out           =   $productRequest->price_out;
				$productObject->quantity     		=   $productRequest->quantity;
				$productObject->detail          	=   $productRequest->detail;
				$productObject->status           	=   $productRequest->status;
				$productObject->created_by      	=   auth::id();
				$productObject->updated_by      	=   auth::id();

				$productObject->save();

				$productsResponse[] = $productObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($productsResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$productsRequest = json_decode($request->input('models'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = Product::findOrFail($productRequest->id);

				$productObject->name 		  		=   $productRequest->name;
				$productObject->product_type_id		=   $productRequest->product_type_id;
				$productObject->barcode        		=   $productRequest->barcode;
				$productObject->price_in            =   $productRequest->price_in;
				$productObject->price_out           =   $productRequest->price_out;
				$productObject->quantity     		=   $productRequest->quantity;
				$productObject->detail          	=   $productRequest->detail;
				$productObject->status           	=   $productRequest->status;
				$productObject->updated_by     		=   auth::id();

				$productObject->save();

				$productsResponse[] = $productObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($productsResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$productsRequest = json_decode($request->input('models'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = Product::findOrFail($productRequest->id);

				$productObject->delete();

				$productsResponse[] = $productRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($prductsResponse);
	}
}
