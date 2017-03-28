<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\MasterDetail;
use App\MasterType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CityController extends Controller
{
    /**
     *The city table
     *
     *@var int
     */
    private $cityTable = 8;

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
        $this->data['title'] = 'City';

        return view('pages.city',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $cities = MasterType::find($this->cityTable)->cityRecords()->get()->sortByDesc('created_at')->values()->all();
        
        return Response()->Json($cities);
    }

    /**
     * Get a listing of the resource that contains(value, text).
     *
     * @return \Illuminate\Http\Response
     */
    public function getList($option = null)
    {
        $cities = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $cities = MasterType::find($this->cityTable)->cityRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $cities = MasterType::find($this->cityTable)->cityRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($cities);
    }

    /**
     * Get a listing of the resource that contains(value, text) belong to country.
     *
     * @return \Illuminate\Http\Response
     */
    public function getListCityByCountry($option = null, $countryId = null)
    {
        $cities = [];

        if($option == 'filter'){
            //Get all city records filter status = enabled
            $cities = MasterDetail::find($countryId)->cityRecords()->where('status',Status::Enabled)->get(['id as value','name as text'])->sortBy('text')->values()->all();
     
        }elseif ($option == 'all') {
            //Get all city records
            $cities = MasterType::find($countryId)->cityRecords()->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }
        
        return Response()->Json($cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $citiesRequest = json_decode($request->input('models'));
  
        foreach ($citiesRequest as $key => $cityRequest) {
            try {

                $cityObject = new MasterDetail();

                $cityObject->master_type_id   =   $this->cityTable;
                $cityObject->name             =   $cityRequest->name;
                $cityObject->description      =   $cityRequest->description;
                $cityObject->status           =   $cityRequest->status;
                $cityObject->created_by       =   auth::id();
                $cityObject->updated_by       =   auth::id();

                $cityObject->save();

                $citiesResponse[] = $cityObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($citiesResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $citiesRequest = json_decode($request->input('models'));
  
        foreach ($citiesRequest as $key => $cityRequest) {
            try {

                $cityObject = MasterDetail::findOrFail($cityRequest->id);

                $cityObject->name         =   $cityRequest->name;
                $cityObject->description  =   $cityRequest->description;
                $cityObject->status       =   $cityRequest->status;
                $cityObject->updated_by   =   auth::id();
                $cityObject->save();

                $citiesResponse[] = $cityObject;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($citiesResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $citiesRequest = json_decode($request->input('models'));
  
        foreach ($citiesRequest as $key => $cityRequest) {
            try {

                $cityObject = MasterDetail::findOrFail($cityRequest->id);

                $cityObject->delete();

                $citiesResponse[] = $cityRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($citiesResponse);
    }
}
