<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
		$this->data['title'] 		= 	'Product List';

		$categoryController 		= 	new CategoryController;
		$this->data['categories'] 	= 	$categoryController->getList('all')->content();

		$branchController 			= 	new BranchController;
		$this->data['branches'] 	= 	$branchController->getList('all')->content();

		$userControler              	=   new UserController;
        $this->data['users']        	=   $userControler->get('foriegnkeycolumn')->content(); 

		return view('pages.products.product',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$products = Product::all()->sortByDesc('id')->values()->all();

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
		$productsRequest = json_decode($request->input('products'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = new Product();

				$productObject->code 		  		=   $productRequest->code;
				$productObject->name 		  		=   $productRequest->name;
				$productObject->category_id			=   $productRequest->category_id;
				$productObject->unit_price        	=   $productRequest->unit_price;
				$productObject->sale_price     		=   $productRequest->sale_price;
				$productObject->quantity           	=   $productRequest->quantity;
				$productObject->quantity_per_unit   =   $productRequest->quantity_per_unit;
				$productObject->discontinue     	=   $productRequest->discontinue;
				$productObject->description         =   $productRequest->description;
				$productObject->branch_id          	=   $productRequest->branch_id;
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
		$productsRequest = json_decode($request->input('products'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = Product::findOrFail($productRequest->id);

				$productObject->code 		  		=   $productRequest->code;
				$productObject->name 		  		=   $productRequest->name;
				$productObject->category_id			=   $productRequest->category_id;
				$productObject->unit_price        	=   $productRequest->unit_price;
				$productObject->sale_price     		=   $productRequest->sale_price;
				$productObject->quantity           	=   $productRequest->quantity;
				$productObject->quantity_per_unit   =   $productRequest->quantity_per_unit;
				$productObject->discontinue     	=   $productRequest->discontinue;
				$productObject->description         =   $productRequest->description;
				$productObject->branch_id          	=   $productRequest->branch_id;
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
		$productsRequest = json_decode($request->input('products'));

		foreach ($productsRequest as $key => $productRequest) {
			try {

				$productObject = Product::findOrFail($productRequest->id);

				$productObject->delete();

				$productsResponse[] = $productRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($productsResponse);
	}
}
