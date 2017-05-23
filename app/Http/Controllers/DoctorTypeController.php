<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Helpers\Status;
use App\Http\Controllers\Controller;
use App\MasterDetail;
use App\MasterType;



class DoctorTypeController extends Controller
{
    
    /**
    *The Doctor type table
    *@var int
    */
    private $doctorTypeTable = 3;

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

        $userControler              =   new UserController;
        $this->data['users']        =   $userControler->get('foriegnkeycolumn')->content();
        
        return view('pages.doctors.type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $doctorType = MasterType::find($this->doctorTypeTable)->doctorTypeRecords()->get()->sortByDesc('id')->values()->all();
        return Response()->Json($doctorType);
    }
    /**
     * Get a listing of the resource for dropdownlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $doctorType = MasterType::find($this->doctorTypeTable)->doctorTypeRecords();
         if($option == 'filter'){
            $doctorType = $doctorType->where('status',Status::ACTIVE); 
        }
        
        $doctorType = $doctorType->get(['id as value','name as text'])->sortBy('text')->values()->all();
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
        $doctortypesRequest = json_decode($request->input('doctors'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = new MasterDetail();

                $doctorTypeObject->master_type_id   =   $this->doctorTypeTable;
                $doctorTypeObject->name             =   $doctortypeRequest->name;
                $doctorTypeObject->description      =   $doctortypeRequest->description;
                $doctorTypeObject->status           =   $doctortypeRequest->status;
                $doctorTypeObject->created_by       =   auth::id();
                $doctorTypeObject->updated_by       =   auth::id();
                $doctorTypeObject->save();

                $doctortypesResponse[] = $doctorTypeObject;

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
        $doctortypesRequest = json_decode($request->input('doctors'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = MasterDetail::findOrFail($doctortypeRequest->id);
                $doctorTypeObject->name         =   $doctortypeRequest->name;
                $doctorTypeObject->description  =   $doctortypeRequest->description;
                $doctorTypeObject->status       =   $doctortypeRequest->status;
                $doctorTypeObject->updated_by   =   auth::id();
                $doctorTypeObject->save();

                $doctortypesResponse[]  =   $doctorTypeObject;

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
        $doctortypesRequest = json_decode($request->input('doctors'));
  
        foreach ($doctortypesRequest as $key => $doctortypeRequest) {
            try {

                $doctorTypeObject = MasterDetail::findOrFail($doctortypeRequest->id);
                $doctorTypeObject->delete();

                $doctortypesResponse[] = $doctortypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($doctortypesResponse);
    }

}
