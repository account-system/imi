<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\MasterDetail;
use App\MasterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorTypeController extends Controller
{
    /**
     *The vendor type table
     *
     *@var int
     */
    private $vendorTypeTable = 4;

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
        $this->data['title'] = 'Vendor Type';

        return view('pages.vendor-type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $vendorTypes = MasterType::find($this->vendorTypeTable)->masterDetails()->get()->sortByDesc('created_at')->values()->all();

        return Response()->Json($vendorTypes);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $vendorTypes = MasterType::find($this->vendorTypeTable)->masterDetails();

        if($option == 'filter'){
            $vendorTypes = $vendorTypes->where('status',Status::Enabled); 
        }
        
        $vendorTypes = $vendorTypes->get(['id as value','name as text'])->sortBy('text')->values()->all();

        return Response()->Json($vendorTypes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $vendortypesRequest = json_decode($request->input('models'));
  
        foreach ($vendortypesRequest as $key => $vendortypeRequest) {
            try {

                $vendorTypeObject = new MasterDetail();

                $vendorTypeObject->master_type_id   =   $this->vendorTypeTable;
                $vendorTypeObject->name             =   $vendortypeRequest->name;
                $vendorTypeObject->description      =   $vendortypeRequest->description;
                $vendorTypeObject->status           =   $vendortypeRequest->status;
                $vendorTypeObject->created_by       =   auth::id();
                $vendorTypeObject->updated_by       =   auth::id();

                $vendorTypeObject->save();

                $vendortypesResponse[] = $vendorTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendortypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $vendortypesRequest = json_decode($request->input('models'));
  
        foreach ($vendortypesRequest as $key => $vendortypeRequest) {
            try {

                $vendorTypeObject = MasterDetail::findOrFail($vendortypeRequest->id);

                $vendorTypeObject->name         =   $vendortypeRequest->name;
                $vendorTypeObject->description  =   $vendortypeRequest->description;
                $vendorTypeObject->status       =   $vendortypeRequest->status;
                $vendorTypeObject->updated_by   =   auth::id();
                $vendorTypeObject->save();

                $vendortypesResponse[] = $vendorTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendortypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $vendortypesRequest = json_decode($request->input('models'));
  
        foreach ($vendortypesRequest as $key => $vendortypeRequest) {
            try {

                $vendorTypeObject = MasterDetail::findOrFail($vendortypeRequest->id);

                $vendorTypeObject->delete();

                $vendortypesResponse[] = $vendortypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendortypesResponse);
    }
}
