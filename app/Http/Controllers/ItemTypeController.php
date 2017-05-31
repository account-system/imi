<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterDetail;

class ItemTypeController extends Controller
{
    /**
    *The item type type table
    *@var int
    */
    private $itemTypeTable = 9;

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
        $this->data['title']    =   'Item Type';

        $userControler          =   new UserController;
        $this->data['users']    =   $userControler->get('foriegnkeycolumn')->content(); 

        return view('pages.items.type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $itemTypes = [];

        if($option == 'dropdownlist'){
            $itemTypes = MasterDetail::where('master_type_id', $this->itemTypeTable)->where('status', Status::ACTIVE)->get(['id as value','name as text'])->sortBy('text')->values()->all();
        }elseif ($option == 'foriegnkeycolumn') {
            $itemTypes = MasterDetail::where('master_type_id', $this->itemTypeTable)->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }elseif($option == 'all'){
            $itemTypes = MasterDetail::where('master_type_id', $this->itemTypeTable)->get()->sortByDesc('id')->values()->all(); 
        }
        
        return Response()->Json($itemTypes);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $itemTypesRequest = json_decode($request->input('itemTypes'));
  
        foreach ($itemTypesRequest as $key => $itemTypeRequest) {
            try {

                $itemTypeObject = new MasterDetail();

                $itemTypeObject->master_type_id   = $this->itemTypeTable;
                $itemTypeObject->name             = $itemTypeRequest->name;
                $itemTypeObject->description      = $itemTypeRequest->description;
                $itemTypeObject->status           = $itemTypeRequest->status;
                $itemTypeObject->created_by       = auth::id();
                $itemTypeObject->updated_by       = auth::id();

                $itemTypeObject->save();

                $itemTypesResponse[] = $itemTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($itemTypesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $itemTypesRequest = json_decode($request->input('itemTypes'));
  
        foreach ($itemTypesRequest as $key => $itemTypeRequest) {
            try {

                $itemTypeObject = MasterDetail::findOrFail($itemTypeRequest->id);

                $itemTypeObject->name         = $itemTypeRequest->name;
                $itemTypeObject->description  = $itemTypeRequest->description;
                $itemTypeObject->status       = $itemTypeRequest->status;
                $itemTypeObject->updated_by   = auth::id();

                $itemTypeObject->save();

                $itemTypesResponse[]   = $itemTypeObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($itemTypesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $itemTypesRequest = json_decode($request->input('itemTypes'));
  
        foreach ($itemTypesRequest as $key => $itemTypeRequest) {
            try {

                $itemTypeObject = MasterDetail::findOrFail($itemTypeRequest->id);

                $itemTypeObject->delete();

                $itemTypesResponse[]= $itemTypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($itemTypesResponse);
    }

}
