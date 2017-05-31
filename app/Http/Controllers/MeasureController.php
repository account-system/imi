<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterDetail;

class MeasureController extends Controller
{
    /**
    *The measure type table
    *@var int
    */
    private $measureTable = 8;

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
        $this->data['title']    =   'Measure';

        $userControler          =   new UserController;
        $this->data['users']    =   $userControler->get('foriegnkeycolumn')->content(); 

        return view('pages.items.measure',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $measures = [];

        if($option == 'dropdownlist'){
            $measures = MasterDetail::where('master_type_id', $this->measureTable)->where('status',Status::ACTIVE)->get(['id as value','name as text'])->sortByDesc('value')->values()->all();
        }elseif ($option == 'foriegnkeycolumn') {
            $measures = MasterDetail::where('master_type_id', $this->measureTable)->get(['id as value','name as text'])->sortByDesc('value')->values()->all(); 
        }elseif($option == 'all'){
            $measures = MasterDetail::where('master_type_id', $this->measureTable)->get()->sortByDesc('id')->values()->all(); 
        }
        
        return Response()->Json($measures);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $measuresRequest = json_decode($request->input('measures'));
  
        foreach ($measuresRequest as $key => $measureRequest) {
            try {

                $measureObject = new MasterDetail();

                $measureObject->master_type_id   = $this->measureTable;
                $measureObject->name             = $measureRequest->name;
                $measureObject->description      = $measureRequest->description;
                $measureObject->status           = $measureRequest->status;
                $measureObject->created_by       = auth::id();
                $measureObject->updated_by       = auth::id();

                $measureObject->save();

                $measuresResponse[] = $measureObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($measuresResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $measuresRequest = json_decode($request->input('measures'));
  
        foreach ($measuresRequest as $key => $measureRequest) {
            try {

                $measureObject = MasterDetail::findOrFail($measureRequest->id);

                $measureObject->name         = $measureRequest->name;
                $measureObject->description  = $measureRequest->description;
                $measureObject->status       = $measureRequest->status;
                $measureObject->updated_by   = auth::id();

                $measureObject->save();

                $measuresResponse[]   = $measureObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($measuresResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $measuresRequest = json_decode($request->input('measures'));
  
        foreach ($measuresRequest as $key => $measureRequest) {
            try {

                $measureObject = MasterDetail::findOrFail($measureRequest->id);

                $measureObject->delete();

                $measuresResponse[]= $measureRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($measuresResponse);
    }

}
