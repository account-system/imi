<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Controller;
use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
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
		$this->data['title'] 			= 	'Item List';

		$itemTypeController				= 	new itemTypeController;
		$this->data['itemTypes']		=	$itemTypeController->getList('foriegnkeycolumn')->content();
		 
		$accountController				=	new accountController;
		$this->data['cogsAccounts'] 	= 	$accountController->getAccountListByAccountType(11, 'foriegnkeycolumn')->content();

		$this->data['incomeAccounts'] 	= 	$accountController->getAccountListByAccountType(10, 'foriegnkeycolumn')->content();

		$this->data['inventoryAccounts']= 	$accountController->getAccountListByAccountType(6, 'foriegnkeycolumn')->content();

		$measureControler				= 	new MeasureController;
		$this->data['measures']			=	$measureControler->getList('foriegnkeycolumn')->content();

		$categoryController 			= 	new CategoryController;
		$this->data['categories'] 		= 	$categoryController->getList('foriegnkeycolumn')->content();

		$branchController 				= 	new BranchController;
		$this->data['branches'] 		= 	$branchController->getList('foriegnkeycolumn')->content();

		$userControler             		=   new UserController;
        $this->data['users']       		=   $userControler->get('foriegnkeycolumn')->content(); 

		return view('pages.items.item',$this->data);
	}

	/**
	 * Get a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function get()
	{
		$items = Item::all()->sortByDesc('id')->values()->all();

		return Response()->Json($items);
	}

	/**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.items.create');
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$itemsRequest = json_decode($request->input('items'));

		foreach ($itemsRequest as $key => $itemRequest) {
			try {

				$itemObject = new Item();

				$itemObject->code 		  		=   $itemRequest->code;
				$itemObject->name 		  		=   $itemRequest->name;
				$itemObject->category_id		=   $itemRequest->category_id;
				$itemObject->unit_price        	=   $itemRequest->unit_price;
				$itemObject->sale_price    		=   $itemRequest->sale_price;
				$itemObject->quantity        	=   $itemRequest->quantity;
				$itemObject->quantity_per_unit 	=   $itemRequest->quantity_per_unit;
				$itemObject->discontinue     	=   $itemRequest->discontinue;
				$itemObject->description     	=   $itemRequest->description;
				$itemObject->branch_id        	=   $itemRequest->branch_id;
				$itemObject->status           	=   $itemRequest->status;
				$itemObject->created_by      	=   auth::id();
				$itemObject->updated_by      	=   auth::id();

				$itemObject->save();

				$itemsResponse[] = $itemObject;

			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($itemsResponse);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request)
	{
		$itemsRequest = json_decode($request->input('items'));

		foreach ($itemsRequest as $key => $itemRequest) {
			try {

				$itemObject = Item::findOrFail($itemRequest->id);

				$itemObject->code 		 		=   $itemRequest->code;
				$itemObject->name 		  		=   $itemRequest->name;
				$itemObject->category_id		=   $itemRequest->category_id;
				$itemObject->unit_price        	=   $itemRequest->unit_price;
				$itemObject->sale_price     	=   $itemRequest->sale_price;
				$itemObject->quantity       	=   $itemRequest->quantity;
				$itemObject->quantity_per_unit	=   $itemRequest->quantity_per_unit;
				$itemObject->discontinue     	=   $itemRequest->discontinue;
				$itemObject->description      	=   $itemRequest->description;
				$itemObject->branch_id      	=   $itemRequest->branch_id;
				$itemObject->status           	=   $itemRequest->status;
				$itemObject->updated_by     	=   auth::id();

				$itemObject->save();

				$itemsResponse[] = $itemObject;
					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($itemsResponse);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request)
	{
		$itemsRequest = json_decode($request->input('items'));

		foreach ($itemsRequest as $key => $itemRequest) {
			try {

				$itemObject = Item::findOrFail($itemRequest->id);

				$itemObject->delete();

				$itemsResponse[] = $itemRequest;

					
			} catch (Exception $e) {
					
			}
		}

		return Response()->Json($itemsResponse);
	}
}
