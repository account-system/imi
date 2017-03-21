<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Status;
use Illuminate\Http\Request;
use App\MasterTypeDetail;
use App\VendorList;

class VendorController extends Controller
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
        $this->data['title'] = 'Vendor List';
        return view('pages.vendor-lists',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $vendors = Vendor::find($this->vendorlists)->vendorTypeTable()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($vendorlist);
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
  
        foreach ($vendortypesRequest as $key => $vendorlistRequest) {
            try {

            	$vendorListObject = new VendorList();
          
                // $vendorListObject = new MasterTypeDetail();
                // $vendorListObject->master_type_id = $this->vendorlists;
            	$vendorListObject->vendor_type_id = $vendorlistRequest->vendor_type_id;
                $vendorListObject->branch_id = $vendorlistRequest->branch_id;
                $vendorListObject->company_name = $vendorlistRequest->company_name;
                $vendorListObject->contact_name = $vendorlistRequest->contact_name;
                $vendorListObject->cantact_title = $vendorlistRequest->cantact_title;
                $vendorListObject->phone = $vendorlistRequest->phone;
                $vendorListObject->email = $vendorlistRequest->email;
                $vendorListObject->fax = $vendorlistRequest->fax;
                $vendorListObject->country = $vendorlistRequest->country;
                $vendorListObject->city = $vendorlistRequest->city;
                $vendorListObject->region = $vendorlistRequest->region;
                $vendorListObject->postal_code = $vendorlistRequest->postal_code;
                $vendorListObject->address = $vendorlistRequest->address;
                $vendorListObject->detail = $vendorlistRequest->detail;
                $vendorListObject->status = $vendorlistRequest->status;
                $vendorListObject->created_by = auth::id();
                $vendorListObject->updated_by = auth::id();
                $vendorListObject->save();

                $vendorlistsResponse[]= $vendorListObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendorlistsResponse);
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
  
        foreach ($vendortypesRequest as $key => $vendorlistRequest) {
            try {

                // $vendorListObject = MasterTypeDetail::findOrFail($vendorlistRequest->id);
                $vendorListObject = new VendorList();
                $vendorListObject->vendor_type_id = $vendorlistRequest->vendor_type_id;
                $vendorListObject->branch_id = $vendorlistRequest->branch_id;
                $vendorListObject->company_name = $vendorlistRequest->company_name;
                $vendorListObject->contact_name = $vendorlistRequest->contact_name;
                $vendorListObject->cantact_title = $vendorlistRequest->cantact_title;
                $vendorListObject->phone = $vendorlistRequest->phone;
                $vendorListObject->email = $vendorlistRequest->email;
                $vendorListObject->fax = $vendorlistRequest->fax;
                $vendorListObject->country = $vendorlistRequest->country;
                $vendorListObject->city = $vendorlistRequest->city;
                $vendorListObject->region = $vendorlistRequest->region;
                $vendorListObject->postal_code = $vendorlistRequest->postal_code;
                $vendorListObject->address = $vendorlistRequest->address;
                $vendorListObject->detail = $vendorlistRequest->detail;
                $vendorListObject->status = $vendorlistRequest->status;
                $vendorListObject->updated_by = auth::id();
                $vendorListObject->save();

                $vendorlistsResponse[]= $vendorListObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendorlistsResponse);
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
  
        foreach ($vendortypesRequest as $key => $vendorlistRequest) {
            try {

                //$vendorListObject = MasterTypeDetail::findOrFail($vendorlistRequest->id);
                
                $vendorListObject = new VendorList();
                $vendorListObject->delete();

                $vendorlistsResponse[]= $vendorlistRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($vendorlistsResponse);
    }
}
