<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\MasterTypeDetail;
use App\MasterType;



class DoctorTypesController extends Controller
{
    
    /**
    *The Doctor type table
    *@var int
    */
    private $doctorTypeTable = 3;

    /**
    *The status of Doctor
    *@var array
    */
    private $status = ['ENABLED','DISABLED'];

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
        $this->data['title'] = 'Doctor Type';
        return view('pages.doctor-type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $doctorType = MasterType::find($this->doctorTypeTable)->masterTypeDetails()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($doctorType);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $doctortypesRequest = json_decode($request->input('models'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = new MasterTypeDetail();
                $doctorTypeObject->master_type_id = $this->doctorTypeTable;

                $doctorTypeObject->name = $doctortypeRequest->name;
                $doctorTypeObject->description = $doctortypeRequest->description;
                $doctorTypeObject->status = $doctortypeRequest->status;
                $doctorTypeObject->created_by = auth::id();
                $doctorTypeObject->updated_by = auth::id();
                $doctorTypeObject->save();

                $doctortypesResponse[]= $doctorTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($doctortypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $doctortypesRequest = json_decode($request->input('models'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = MasterTypeDetail::findOrFail($doctortypeRequest->id);
                $doctorTypeObject->name = $doctortypeRequest->name;
                $doctorTypeObject->description = $doctortypeRequest->description;
                $doctorTypeObject->status = $doctortypeRequest->status;
                $doctorTypeObject->updated_by = auth::id();
                $doctorTypeObject->save();

                $doctortypesResponse[]= $doctorTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($doctortypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $doctortypesRequest = json_decode($request->input('models'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = MasterTypeDetail::findOrFail($doctortypeRequest->id);
                $doctorTypeObject->delete();

                $doctortypesResponse[]= $doctortypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($doctortypesResponse);
    }

}
