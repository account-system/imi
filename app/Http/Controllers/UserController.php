<?php

namespace App\Http\Controllers;

use App\Http\Controllers\CityController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\Helpers\Data;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
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
        $this->data['title']        =   'User List';

        $this->data['roles']        =   Data::role();
        
        $branchController           =   new BranchController;
        $this->data['branches']     =   $branchController->getList('all')->content();

        $countryController          =   new CountryController;
        $this->data['countries']    =   $countryController->getList('all')->content();

        $cityController             =   new CityController;
        $this->data['cities']       =   $cityController->getList('all')->content();

        return view('pages.users.user',$this->data);
    }

    /**
     * Get a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get()
    {
        $users = User::whereIn('role',array_column(Data::role(), 'value'))->get()->sortByDesc('id')->values()->all();
        return Response()->Json($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $usersRequest = json_decode($request->input('users'));

        foreach ($usersRequest as $key => $userRequest) {
            try {

                $userObject = new User();

                $userObject->first_name         =   $userRequest->first_name;
                $userObject->last_name          =   $userRequest->last_name;
                $userObject->gender             =   $userRequest->gender;
                $userObject->role               =   $userRequest->role;
                $userObject->branches           =   $userRequest->branchrs;
                $userObject->password           =   bcrypt(Data::DEFAULT_PASSWORD);
                $userObject->phone              =   $userRequest->phone;
                $userObject->email              =   $userRequest->email;
                $userObject->country_id         =   $userRequest->country_id;
                $userObject->city_id            =   $userRequest->city_id;
                $userObject->region             =   $userRequest->region;
                $userObject->postal_code        =   $userRequest->postal_code;
                $userObject->address            =   $userRequest->address;
                $userObject->detail             =   $userRequest->detail;
                $userObject->status             =   $userRequest->status;
                $userObject->created_by         =   auth::id();
                $userObject->updated_by         =   auth::id();

                $userObject->save();

                $usersResponse[] = $userObject;

            } catch (Exception $e) {
                    
            }
        }

        return Response()->Json($usersResponse);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $usersRequest = json_decode($request->input('users'));

        foreach ($usersRequest as $key => $userRequest) {
            try {

                $userObject = User::findOrFail($userRequest->id);

                $userObject->first_name         =   $userRequest->first_name;
                $userObject->last_name          =   $userRequest->last_name;
                $userObject->gender             =   $userRequest->gender;
                $userObject->role               =   $userRequest->role;
                $userObject->branchrs           =   $userRequest->branchrs;
                $userObject->phone              =   $userRequest->phone;
                $userObject->email              =   $userRequest->email;
                $userObject->country_id         =   $userRequest->country_id;
                $userObject->city_id            =   $userRequest->city_id;
                $userObject->region             =   $userRequest->region;
                $userObject->postal_code        =   $userRequest->postal_code;
                $userObject->address            =   $userRequest->address;
                $userObject->detail             =   $userRequest->detail;
                $userObject->status             =   $userRequest->status;
                $userObject->updated_by         =   auth::id();

                $userObject->save();

                $usersResponse[] = $userObject;

            } catch (Exception $e) {
                    
            }
        }

        return Response()->Json($usersResponse);
    }

    /**
     * Remove the specified resource from storage.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $usersRequest = json_decode($request->input('users'));
  
        foreach ($usersRequest as $key => $userRequest) {
            try {

                $branchObject = User::findOrFail($userRequest->id);

                $branchObject->delete();

                $usersResponse[] = $userRequest;

            } catch (Exception $e) {
                
            }
        }

        return Response()->Json($usersResponse);
    }
}
