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
    private $categoryTable = 5;

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
        $this->data['title'] = 'Category List';
        return view('pages.products.category',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $categories = MasterType::find($this->categoryTable)->categoryRecords()->get()->sortByDesc('id')->values()->all();
        return Response()->Json($categories);
    }
    /**
     * Get a listing of the resource that contains(value, text)
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option=null)
    {
        $categories = [];

        if($option == 'filter'){
            //Get all category records filter status = enabled
            $categories = MasterType::find($this->categoryTable)->categoryRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all category records
            $categories = MasterType::find($this->categoryTable)->categoryRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($categories);

    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoriesRequest = json_decode($request->input('categories'));
  
        foreach ($categoriesRequest as $key => $categoryRequest) {
            try {

                $categoryObject = new MasterDetail();

                $categoryObject->master_type_id   = $this->categoryTable;
                $categoryObject->name             = $categoryRequest->name;
                $categoryObject->description      = $categoryRequest->description;
                $categoryObject->status           = $categoryRequest->status;
                $categoryObject->created_by       = auth::id();
                $categoryObject->updated_by       = auth::id();

                $categoryObject->save();

                $categoriesResponse[]= $categoryObject;

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
        $categoriesRequest = json_decode($request->input('categories'));
  
        foreach ($categoriesRequest as $key => $categoryRequest) {
            try {

                $categoryObject = MasterDetail::findOrFail($categoryRequest->id);

                $categoryObject->name         = $categoryRequest->name;
                $categoryObject->description  = $categoryRequest->description;
                $categoryObject->status       = $categoryRequest->status;
                $categoryObject->updated_by   = auth::id();

                $categoryObject->save();

                $categoriesResponse[]   = $categoryObject;

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
        $categoriesRequest = json_decode($request->input('categories'));
  
        foreach ($categoriesRequest as $key => $categoryRequest) {
            try {

                $categoryObject = MasterDetail::findOrFail($categoryRequest->id);

                $categoryObject->delete();

                $categoriesResponse[]= $categoryRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($categoriesResponse);
    }

}
