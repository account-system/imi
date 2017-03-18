<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\MasterTypeDetail;
use App\MasterType;

class CategoriessController extends Controller
{
    /**
    *The category type table
    *@var int
    */
    private $categoriesTable = 5;

    /**
    *The status of category
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
        $this->data['title'] = 'Category Product';
        return view('pages.categoriess',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $vendorType = MasterType::find($this->categoriesTable)->masterTypeDetails()->get()->sortByDesc('created_at')->values()->all();
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
        $categoriessRequest = json_decode($request->input('models'));
  
        foreach ($categoriessRequest as $key => $categoriesRequest) {
            try {

                $categoriesObject = new MasterTypeDetail();
                $categoriesObject->master_type_id = $this->categoriesTable;

                $categoriesObject->name = $categoriesRequest->name;
                $categoriesObject->description = $categoriesRequest->description;
                $categoriesObject->status = $categoriesRequest->status;
                $categoriesObject->created_by = auth::id();
                $categoriesObject->updated_by = auth::id();
                $categoriesObject->save();

                $categoriesResponse[]= $categoriesObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($categoriesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $categoriessRequest = json_decode($request->input('models'));
  
        foreach ($categoriessRequest as $key => $categoriesRequest) {
            try {

                $categoriesObject = MasterTypeDetail::findOrFail($categoriesRequest->id);
                $categoriesObject->name = $categoriesRequest->name;
                $categoriesObject->description = $categoriesRequest->description;
                $categoriesObject->status = $categoriesRequest->status;
                $categoriesObject->updated_by = auth::id();
                $categoriesObject->save();

                $categoriesResponse[]= $categoriesObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($categoriesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $categoriessRequest = json_decode($request->input('models'));
  
        foreach ($categoriessRequest as $key => $categoriesRequest) {
            try {

                $categoriesObject = MasterTypeDetail::findOrFail($categoriesRequest->id);
                $categoriesObject->delete();

                $categoriesResponse[]= $categoriesRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($categoriesResponse);
    }

}
