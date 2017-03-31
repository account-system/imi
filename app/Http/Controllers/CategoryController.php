<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\MasterDetail;
use App\MasterType;

class CategoryController extends Controller
{
    /**
    *The category type table
    *@var int
    */
    private $categoriesTable = 5;

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
        $this->data['title'] = 'Category';
        return view('pages.categoriess',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $category = MasterType::find($this->categoriesTable)->categoryRecords()->get()->sortByDesc('created_at')->values()->all();
        return Response()->Json($category);
    }
    /**
     * Get a listing of the resource for dropdownlist.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $category = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $category = MasterType::find($this->categoriesTable)->categoryRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $category = MasterType::find($this->categoriesTable)->categoryRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($category);

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

                $categoriesObject = new MasterDetail();

                $categoriesObject->master_type_id   = $this->categoriesTable;
                $categoriesObject->name             = $categoriesRequest->name;
                $categoriesObject->description      = $categoriesRequest->description;
                $categoriesObject->status           = $categoriesRequest->status;
                $categoriesObject->created_by       = auth::id();
                $categoriesObject->updated_by       = auth::id();
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

                $categoriesObject = MasterDetail::findOrFail($categoriesRequest->id);
                $categoriesObject->name         = $categoriesRequest->name;
                $categoriesObject->description  = $categoriesRequest->description;
                $categoriesObject->status       = $categoriesRequest->status;
                $categoriesObject->updated_by   = auth::id();
                $categoriesObject->save();

                $categoriesResponse[]   = $categoriesObject;

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

                $categoriesObject = MasterDetail::findOrFail($categoriesRequest->id);
                $categoriesObject->delete();

                $categoriesResponse[]= $categoriesRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($categoriesResponse);
    }

}
