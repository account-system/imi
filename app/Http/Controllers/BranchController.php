<?php

namespace App\Http\Controllers;

use App\Branch;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchController extends Controller
{
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

        $branchs = Branch::get()->sortByDesc('id')->values()->all();

        return Response()->Json($branchs);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $branchs = [];

        if($option == 'filter'){
            //Get all branch records filter status = enabled
            $branchs = Branch::where('status',Status::ACTIVE)->whereIn('id',array_column(auth::user()->branches, 'value'))->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all branch records
            $branchs = Branch::get(['id as value','name as text'])->sortBy('text')->values()->all(); 
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
       $branchsRequest = json_decode($request->input('branches'));
  
        foreach ($branchsRequest as $key => $branchRequest) {
            try {

                $branchObject = new MasterDetail();

                $branchObject->master_type_id   =   $this->branchTable;
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
        $branchsRequest = json_decode($request->input('branches'));
  
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
        $branchsRequest = json_decode($request->input('branches'));
  
        foreach ($branchsRequest as $key => $branchRequest) {
            try {

                $branchObject = MasterDetail::findOrFail($branchRequest->id);

                $branchObject->delete();

                $branchsResponse[] = $branchRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($branchsResponse);
    }
}
