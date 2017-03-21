<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterTypeDetail;
use App\MasterType;

class EmployeeTypesController extends Controller
{
    /**
    *The Employee type table
    *@var int
    */
    private $employeeTypeTable = 2;

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
        $this->data['title'] = 'Employee Type';
        return view('pages.employee-types',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $employeeType = MasterType::find($this->employeeTypeTable)->masterTypeDetails()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($employeeType);
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
        $employeetypesRequest = json_decode($request->input('models'));
  
        foreach ($employeetypesRequest as $key => $employeetypeRequest) {
            try {

                $employeeTypeObject = new MasterTypeDetail();
                $employeeTypeObject->master_type_id = $this->employeeTypeTable;

                $employeeTypeObject->name = $employeetypeRequest->name;
                $employeeTypeObject->description = $employeetypeRequest->description;
                $employeeTypeObject->status = $employeetypeRequest->status;
                $employeeTypeObject->created_by = auth::id();
                $employeeTypeObject->updated_by = auth::id();
                $employeeTypeObject->save();

                $employeetypesResponse[]= $employeeTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($employeetypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $employeetypesRequest = json_decode($request->input('models'));
  
        foreach ($employeetypesRequest as $key => $employeetypeRequest) {
            try {

                $employeeTypeObject = MasterTypeDetail::findOrFail($employeetypeRequest->id);
                $employeeTypeObject->name = $employeetypeRequest->name;
                $employeeTypeObject->description = $employeetypeRequest->description;
                $employeeTypeObject->status = $employeetypeRequest->status;
                $employeeTypeObject->updated_by = auth::id();
                $employeeTypeObject->save();

                $employeetypesResponse[]= $employeeTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($employeetypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $employeetypesRequest = json_decode($request->input('models'));
  
        foreach ($employeetypesRequest as $key => $employeetypeRequest) {
            try {

                $employeeTypeObject = MasterTypeDetail::findOrFail($employeetypeRequest->id);
                $employeeTypeObject->delete();

                $employeetypesResponse[]= $employeetypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($employeetypesResponse);
    }
}
