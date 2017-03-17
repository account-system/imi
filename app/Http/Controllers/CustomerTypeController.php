<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\CustomerType;

class CustomerTypeController extends Controller
{
    /**
    *The information we send to the view
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
        $this->data['title'] = 'Customer Type';
        return view('pages.customer-type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $customerTypes = CustomerType::all();
        return Response()->Json($customerTypes);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customertypesRequest = json_decode($request->input('models'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = new CustomerType();
                $customerTypeObject->name = $customertypeRequest->name;
                $customerTypeObject->description = $customertypeRequest->description;
                $customerTypeObject->status = $customertypeRequest->status;
                $customerTypeObject->created_by = auth::id();
                $customerTypeObject->updated_by = auth::id();
                $customerTypeObject->save();

                $customertypesResponse[]= $customerTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($customertypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $customertypesRequest = json_decode($request->input('models'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = CustomerType::findOrFail($customertypeRequest->id);
                $customerTypeObject->name = $customertypeRequest->name;
                $customerTypeObject->description = $customertypeRequest->description;
                $customerTypeObject->status = $customertypeRequest->status;
                $customerTypeObject->updated_by = auth::id();
                $customerTypeObject->save();

                $customertypesResponse[]= $customerTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($customertypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $customertypesRequest = json_decode($request->input('models'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = CustomerType::findOrFail($customertypeRequest->id);
                $customerTypeObject->delete();

                $customertypesResponse[]= $customertypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($customertypesResponse);
    }
}
