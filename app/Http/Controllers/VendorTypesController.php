<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterTypeDetail;
use App\MasterType;


class VendorTypesController extends Controller
{
    /**
    *The vendor type table
    *@var int
    */
    private $vendorTypeTable = 4;

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
        $this->data['title'] = 'Vendor Type';
        return view('pages.vendor-types',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $vendorType = MasterType::find($this->vendorTypeTable)->masterTypeDetails()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($vendorType);
    }

    /**
     * Get a listing of the resource for dropdownlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function lists()
    {
        $vendorType = MasterType::find($this->vendorTypeTable)->masterTypeDetails()->where('status',Status::ENABLED)->get(['id','name'])->sortBy('name')->values()->all();
        return Response()->Json($vendorType);
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

                $vendorTypeObject = new MasterTypeDetail();
                $vendorTypeObject->master_type_id = $this->vendorTypeTable;

                $vendorTypeObject->name = $vendortypeRequest->name;
                $vendorTypeObject->description = $vendortypeRequest->description;
                $vendorTypeObject->status = $vendortypeRequest->status;
                $vendorTypeObject->created_by = auth::id();
                $vendorTypeObject->updated_by = auth::id();
                $vendorTypeObject->save();

                $vendortypesResponse[]= $vendorTypeObject;

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

                $vendorTypeObject = MasterTypeDetail::findOrFail($vendortypeRequest->id);
                $vendorTypeObject->name = $vendortypeRequest->name;
                $vendorTypeObject->description = $vendortypeRequest->description;
                $vendorTypeObject->status = $vendortypeRequest->status;
                $vendorTypeObject->updated_by = auth::id();
                $vendorTypeObject->save();

                $vendortypesResponse[]= $vendorTypeObject;

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

                $vendorTypeObject = MasterTypeDetail::findOrFail($vendortypeRequest->id);
                $vendorTypeObject->delete();

                $vendortypesResponse[]= $vendortypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendortypesResponse);
    }
}
