<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class InventoryController extends Controller
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
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->data['title'] = 'Add Item';

        return view('pages.items.inventories.create', $this->data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['item_type_id'] = 1;
        $data['created_by'] = auth::id();
        $data['updated_by'] = auth::id();
        Validator::make($data, [
            'item_type_id' => 'required|numeric',
            'name' => 'required|max:60',
            'code_barcode' => 'nullable|max:60',
            'qr_code' => 'nullable|max:60',
            'lot_number' => 'nullable|max:60',
            'sku' => 'nullable|max:60',
            'expire_date' => 'nullable|date|date_format:Y/m/d',
            'image' => 'nullable|image|mimes:gif,jpeg,png',
            'category_id' => 'nullable|numeric',
            'measure_id' => 'nullable|numeric',
            'discontinue' => 'required|boolean',
            'on_hand' => 'required|numeric',
            'as_of_date' => 'required|date|date_format:Y/m/d',
            'reorder_point' => 'nullable|numeric',
            'inventory_account_id' => 'required|numeric',
            'sale_description' => 'nullable|max:200',
            'price' => 'nullable|numeric',
            'income_account_id' => 'required|numeric',
            'purchase_description' => 'nullable|max:200',
            'cost' => 'nullable|numeric',
            'expense_account_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'status' => 'required|in:Active,Inactive' 
        ])->validate();

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $image = $request->file('image');
            $image->move('images', $image->getClientOriginalName());
            $data['image'] = $image->getClientOriginalName();
        }

        $inventory = Item::create($data);

        // show a success message
        \Alert::success('The item has been added successfully.')->flash();

        If($data['save_action']==='save_and_back'){
            return redirect(url('').'/item');
        }elseif($data['save_action']==='save_and_edit'){

        }elseif ($data['save_action']==='save_and_new') {
            
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->data['title'] = 'Edit Item';

        $inventory = Item::find($id);
        
        return view('pages.items.inventories.edit', $this->data)->with($inventory->toArray());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['item_type_id'] = 1;
        $data['updated_by'] = auth::id();
        Validator::make($data, [
            'item_type_id' => 'required|numeric',
            'name' => 'required|max:60',
            'code_barcode' => 'nullable|max:60',
            'qr_code' => 'nullable|max:60',
            'lot_number' => 'nullable|max:60',
            'sku' => 'nullable|max:60',
            'expire_date' => 'nullable|date|date_format:Y/m/d',
            'image' => 'nullable|image|mimes:gif,jpeg,png',
            'category_id' => 'nullable|numeric',
            'measure_id' => 'nullable|numeric',
            'discontinue' => 'required|boolean',
            'on_hand' => 'required|numeric',
            'as_of_date' => 'required|date|date_format:Y/m/d',
            'reorder_point' => 'nullable|numeric',
            'inventory_account_id' => 'required|numeric',
            'sale_description' => 'nullable|max:200',
            'price' => 'nullable|numeric',
            'income_account_id' => 'required|numeric',
            'purchase_description' => 'nullable|max:200',
            'cost' => 'nullable|numeric',
            'expense_account_id' => 'required|numeric',
            'branch_id' => 'required|numeric',
            'status' => 'required|in:Active,Inactive' 
        ])->validate();

        if($request->hasFile('image') && $request->file('image')->isValid()){
            $image = $request->file('image');
            $image->move('images', $image->getClientOriginalName());
            $data['image'] = $image->getClientOriginalName();
        }

        $inventory = Item::find($id)->update($data);

        // show a success message
        \Alert::success('The item has been modified successfully.')->flash();

        If($data['save_action']==='save_and_back'){
            return redirect(url('').'/item');
        }elseif($data['save_action']==='save_and_edit'){

        }elseif ($data['save_action']==='save_and_new') {
            
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
