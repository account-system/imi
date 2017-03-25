<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\MasterDetail;
use App\MasterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
    /**
     *The branch table
     *
     *@var int
     */
    private $branchTable = 6;

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
        $this->data['title'] = 'Branch';

        return view('pages.branch',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $branchs = MasterType::find($this->branchTable)->branchRecords()->get()->sortByDesc('created_at')->values()->all();

        return Response()->Json($branchs);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $branchs = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $branchs = MasterType::find($this->branchTable)->branchRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $branchs = MasterType::find($this->branchTable)->branchRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($branchs);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $branchsRequest = json_decode($request->input('models'));
  
        foreach ($branchsRequest as $key => $branchRequest) {
            try {

                $branchObject = new MasterDetail();

                $branchObject->master_type_id   =   $this->vendorTypeTable;
                $branchObject->name             =   $branchRequest->name;
                $branchObject->description      =   $branchRequest->description;
                $branchObject->status           =   $branchRequest->status;
                $branchObject->created_by       =   auth::id();
                $branchObject->updated_by       =   auth::id();

                $branchObject->save();

                $branchsResponse[] = $branchObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($branchsResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $branchsRequest = json_decode($request->input('models'));
  
        foreach ($branchsRequest as $key => $branchRequest) {
            try {

                $branchObject = MasterDetail::findOrFail($branchRequest->id);

                $branchObject->name         =   $branchRequest->name;
                $branchObject->description  =   $branchRequest->description;
                $branchObject->status       =   $branchRequest->status;
                $branchObject->updated_by   =   auth::id();

                $branchObject->save();

                $branchsResponse[] = $branchObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($branchsResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $branchsRequest = json_decode($request->input('models'));
  
        foreach ($branchsRequest as $key => $branchRequest) {
            try {

                $branchObject = MasterTypeDetail::findOrFail($branchRequest->id);

                $branchObject->delete();

                $branchsResponse[] = $branchRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($branchsResponse);
    }
}
