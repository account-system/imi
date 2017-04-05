<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Helpers\Status;
use App\Http\Controllers\Controller;

use App\MasterDetail;
use App\MasterType;

class ProductTypeController extends Controller
{
    /**
    *The product type table
    *@var int
    */
    private $productTypeTable = 5;

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
        $this->data['title'] = 'Product Type';
        return view('pages.products.Type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $productTypes = MasterType::find($this->productTypeTable)->productRecords()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($productTypes);
    }
    /**
     * Get a listing of the resource for dropdownlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $productTypes = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $productTypes = MasterType::find($this->productTypeTable)->productRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $productTypes = MasterType::find($this->productTypeTable)->productRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($productTypes);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productTypesRequest = json_decode($request->input('models'));
  
        foreach ($productTypesRequest as $key => $productTypesRequest) {
            try {

                $productTypesObject = new MasterDetail();

                $productTypesObject->master_type_id   = 	$this->productTypeTable;
                $productTypesObject->name             = 	$productTypesRequest->name;
                $productTypesObject->description      = 	$productTypesRequest->description;
                $productTypesObject->status           = 	$productTypesRequest->status;
                $productTypesObject->created_by       = 	auth::id();
                $productTypesObject->updated_by       = 	auth::id();
                $productTypesObject->save();

                $productTypesResponse[]= $productTypesObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($productTypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $productTypesRequest = json_decode($request->input('models'));
  
        foreach ($productTypesRequest as $key => $productTypesRequest) {
            try {

                $productTypesObject = MasterDetail::findOrFail($productTypesRequest->id);
                $productTypesObject->name         = 	$productTypesRequest->name;
                $productTypesObject->description  = 	$productTypesRequest->description;
                $productTypesObject->status       = 	$productTypesRequest->status;
                $productTypesObject->updated_by   = 	auth::id();
                $productTypesObject->save();

                $productTypesResponse[]   = $productTypesObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($productTypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $productTypesRequest = json_decode($request->input('models'));
  
        foreach ($productTypesRequest as $key => $productTypesRequest) {
            try {

                $productTypesObject = MasterDetail::findOrFail($productTypesRequest->id);
                $productTypesObject->delete();

                $productTypesResponse[]= $productTypesRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($productTypesResponse);
    }
}
