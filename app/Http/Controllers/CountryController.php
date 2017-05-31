<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\MasterDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CountryController extends Controller
{
    /**
     *The country table
     *
     *@var int
     */
    private $countryTable = 6;

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
        $this->data['title']    =   'Setup Country & Citry';

        $userControler          =   new UserController;
        $this->data['users']    =   $userControler->get('foriegnkeycolumn')->content(); 

        return view('pages.country-city',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $countries = MasterDetail::where('master_type_id', $this->countryTable)->get()->sortByDesc('id')->values()->all();

        return Response()->Json($countries);
    }

    /**
     * Get a listing of the resource that contains(value, text or countryId, countryName) depend on param $option
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        
        $countries = [];

        if($option == 'filter'){
            //Get all country records filter status = enabled contains(value, text) 
            $countries = MasterDetail::where('master_type_id', $this->countryTable)->where('status',Status::ACTIVE)->get(['id as value','name as text'])->sortBy('text')->values()->all();
        }elseif ($option == 'cascade') {
            //Get all country records filter status = enabled contains(countryId, countryName)
            $countries = MasterDetail::where('master_type_id', $this->countryTable)->where('status',Status::ACTIVE)->get(['id as countryId','name as countryName'])->sortBy('text')->values()->all();
        }
        elseif ($option == 'all') {
            //Get all country records contains(value, text)
            $countries = MasterDetail::where('master_type_id', $this->countryTable)->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countriesRequest = json_decode($request->input('countries'));
  
        foreach ($countriesRequest as $key => $countryRequest) {
            try {

                $countryObject = new MasterDetail();

                $countryObject->master_type_id      =   $this->countryTable;
                $countryObject->name                =   $countryRequest->name;
                $countryObject->description         =   $countryRequest->description;
                $countryObject->status              =   $countryRequest->status;
                $countryObject->created_by          =   auth::id();
                $countryObject->updated_by          =   auth::id();

                $countryObject->save();

                $countriesResponse[] = $countryObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($countriesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $countriesRequest = json_decode($request->input('countries'));
  
        foreach ($countriesRequest as $key => $countryRequest) {
            try {

                $countryObject = MasterDetail::findOrFail($countryRequest->id);

                $countryObject->name                =   $countryRequest->name;
                $countryObject->description         =   $countryRequest->description;
                $countryObject->status              =   $countryRequest->status;
                $countryObject->updated_by          =   auth::id();

                $countryObject->save();

                $countriesResponse[] = $countryObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($countriesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $countriesRequest = json_decode($request->input('countries'));
  
        foreach ($countriesRequest as $key => $countryRequest) {
            try {

                $countryObject = MasterDetail::findOrFail($countryRequest->id);

                $countryObject->delete();

                $countriesResponse[] = $countryRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($countriesResponse);
    }
}
