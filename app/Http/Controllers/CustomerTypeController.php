<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Helpers\Status;
use Illuminate\Http\Request;
use App\MasterType;
use App\MasterDetail;

class CustomerTypeController extends Controller
{
    /**
    *The customer type table
    *@var int
    */
    private $customerTypeTable = 1;

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
        $this->data['title'] = 'Customer Type';

        $userControler              =   new UserController;
        $this->data['users']        =   $userControler->get('foriegnkeycolumn')->content();
        
        return view('pages.customers.type',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $customerTypes = MasterType::find($this->customerTypeTable)->customerTypeRecords()->get()->sortByDesc('id')->values()->all();
        return Response()->Json($customerTypes);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $customerTypes = [];

        if($option == 'filter'){
            //Get all customer type records filter status = enabled
            $customerTypes = MasterType::find($this->customerTypeTable)->customerTypeRecords()->where('status',Status::ACTIVE)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all customer type records
            $customerTypes = MasterType::find($this->customerTypeTable)->customerTypeRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
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
        $customertypesRequest = json_decode($request->input('customers'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = new MasterDetail();
                
                $customerTypeObject->master_type_id     = $this->customerTypeTable;
                $customerTypeObject->name               = $customertypeRequest->name;
                $customerTypeObject->description        = $customertypeRequest->description;
                $customerTypeObject->status             = $customertypeRequest->status;
                $customerTypeObject->created_by         = auth::id();
                $customerTypeObject->updated_by         = auth::id();

                $customerTypeObject->save();

                $customertypesResponse[] = $customerTypeObject;

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
        $customertypesRequest = json_decode($request->input('customers'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = MasterDetail::findOrFail($customertypeRequest->id);

                $customerTypeObject->name           = $customertypeRequest->name;
                $customerTypeObject->description    = $customertypeRequest->description;
                $customerTypeObject->status         = $customertypeRequest->status;
                $customerTypeObject->updated_by     = auth::id();

                $customerTypeObject->save();

                $customertypesResponse[] = $customerTypeObject;

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
        $customertypesRequest = json_decode($request->input('customers'));
  
        foreach ($customertypesRequest as $key => $customertypeRequest) {
            try {

                $customerTypeObject = MasterDetail::findOrFail($customertypeRequest->id);
                
                $customerTypeObject->delete();

                $customertypesResponse[] = $customertypeRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($customertypesResponse);
    }
}
