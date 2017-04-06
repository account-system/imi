<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\MasterDetail;
use App\MasterType;
/**
 *
 *@param
 */
class SupplierTypeController extends Controller
{
    
     /**
     *The supplier type table
     *
     *@var int
     */
    private $supplierTypeTable = 4;

    /**
     *The information we send to the view
     *
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
        $this->data['title'] = 'Supplier Type';

        return view('pages.suppliers.type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $supplierTypes = MasterType::find($this->supplierTypeTable)->supplierTypeRecords()->get()->sortByDesc('id')->values()->all();
        
        return Response()->Json($supplierTypes);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $supplierTypes = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $supplierTypes = MasterType::find($this->supplierTypeTable)->supplierTypeRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $supplierTypes = MasterType::find($this->supplierTypeTable)->supplierTypeRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($supplierTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $suppliertypesRequest = json_decode($request->input('models'));
  
        foreach ($suppliertypesRequest as $key => $suppliertypeRequest) {
            try {

                $supplierTypeObject = new MasterDetail();

                $supplierTypeObject->master_type_id   =   $this->supplierTypeTable;
                $supplierTypeObject->name             =   $suppliertypeRequest->name;
                $supplierTypeObject->description      =   $suppliertypeRequest->description;
                $supplierTypeObject->status           =   $suppliertypeRequest->status;
                $supplierTypeObject->created_by       =   auth::id();
                $supplierTypeObject->updated_by       =   auth::id();

                $supplierTypeObject->save();

                $suppliertypesResponse[] = $supplierTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($suppliertypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $suppliertypesRequest = json_decode($request->input('models'));
  
        foreach ($suppliertypesRequest as $key => $suppliertypeRequest) {
            try {

                $supplierTypeObject = MasterDetail::findOrFail($suppliertypeRequest->id);

                $supplierTypeObject->name         =   $suppliertypeRequest->name;
                $supplierTypeObject->description  =   $suppliertypeRequest->description;
                $supplierTypeObject->status       =   $suppliertypeRequest->status;
                $supplierTypeObject->updated_by   =   auth::id();
                $supplierTypeObject->save();

                $suppliertypesResponse[] = $supplierTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($suppliertypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $suppliertypesRequest = json_decode($request->input('models'));
  
        foreach ($suppliertypesRequest as $key => $suppliertypeRequest) {
            try {

                $supplierTypeObject = MasterDetail::findOrFail($suppliertypeRequest->id);

                $supplierTypeObject->delete();

                $suppliertypesResponse[] = $suppliertypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($suppliertypesResponse);
    }
}
