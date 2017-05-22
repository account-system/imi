<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
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
     * Display page chart of account.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewAccount()
    {
        $this->data['title']        =   'Chart of Account';

        $accountTypes               =   $this->getAccountTypeList('foriegnkeycolumn');
        $this->data['accountTypes'] =   $accountTypes->content();

        $accounts                   =   $this->getAccountList('foriegnkeycolumn');
        $this->data['accounts']     =   $accounts->content();

        $userControler              =   new UserController;
        $this->data['users']        =   $userControler->get('foriegnkeycolumn')->content();

        return view('pages.accounts.account', $this->data);
    }

    /**
     * Get a listing of chart of account.
     * @param string $option
     * @return \Illuminate\Http\Response
     */
    public function getAccountList($option = null)
    {
        $accounts = [];

        if($option == 'dropdownlist'){
            $accounts = DB::table('accounts')->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')->select('accounts.id as accountId', 'accounts.code as accountCode', 'Accounts.name as accountName', 'Accounts.account_type_id as accountTypeId', 'account_types.name as accountTypeName')->where('accounts.status', Status::ENABLED)->orderBy('accountName', 'asc')->get();
        }elseif($option == 'foriegnkeycolumn'){
             $accounts = DB::table('accounts')->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')->select('accounts.id as accountId', 'accounts.code as accountCode', 'Accounts.name as accountName', 'Accounts.account_type_id as accountTypeId', 'account_types.name as accountTypeName')->orderBy('accountName', 'asc')->get();
        }elseif($option == 'all'){
            $accounts = Account::all();
        }

        return Response()->Json($accounts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeAccount(Request $request)
    {
        $accountsRequest = json_decode($request->input('accounts'));

        foreach ($accountsRequest as $key => $accountRequest) {
            try {

                $accountObject = new Account();

                $accountObject->account_type_id     =   $accountRequest->account_type_id;
                $accountObject->parent_account_id   =   $accountRequest->parent_account_id;
                $accountObject->code                =   $accountRequest->code;
                $accountObject->name                =   $accountRequest->name;
                $accountObject->description         =   $accountRequest->description;
                $accountObject->status              =   $accountRequest->status;
                $accountObject->created_by          =   auth::id();
                $accountObject->updated_by          =   auth::id();

                $accountObject->save();

                $accountsResponse[] = $accountObject;

            } catch (Exception $e) {
                    
            }
        }

        return Response()->Json($accountsResponse);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateAccount(Request $request)
    {
        $accountsRequest = json_decode($request->input('accounts'));

        foreach ($accountsRequest as $key => $accountRequest) {
            try {

                $accountObject = Account::findOrFail($accountRequest->id);

                $accountObject->account_type_id     =   $accountRequest->account_type_id;
                $accountObject->parent_account_id   =   $accountRequest->parent_account_id;
                $accountObject->code                =   $accountRequest->code;
                $accountObject->name                =   $accountRequest->name;
                $accountObject->description         =   $accountRequest->description;
                $accountObject->status              =   $accountRequest->status;
                $accountObject->updated_by          =   auth::id();

                $accountObject->save();

                $accountsResponse[] = $accountObject;

            } catch (Exception $e) {
                    
            }
        }

        return Response()->Json($accountsResponse);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyAccount(Request $request)
    {
        $accountsRequest = json_decode($request->input('accounts'));

        foreach ($accountsRequest as $key => $accountRequest) {
            try {

                $accountObject = Account::findOrFail($accountRequest->id);

                $accountObject->delete();

                $accountsResponse[] = $accountRequest;

            } catch (Exception $e) {
                    
            }
        }

        return Response()->Json($accountsResponse);
    }

    /**
     * Get a listing of account type.
     * @param string $option
     * @return \Illuminate\Http\Response
     */
    public function getAccountTypeList($option = null)
    {
        $accountTypes = [];

        if($option == 'dropdownlist'){
            $accountTypes = AccountType::where('status', Status::ENABLED)->get(['id as accountTypeId','name as accountTypeName', 'class'])->sortBy('accountTypeName')->values()->all();
        }elseif($option == 'foriegnkeycolumn'){
             $accountTypes = AccountType::get(['id as accountTypeId','name as accountTypeName', 'class'])->sortBy('accountTypeName')->values()->all();  
        }elseif ($option == 'all') {
            $accountTypes = AccountType::all()->sortBy('id')->values()->all(); 
        }
        
        return Response()->Json($accountTypes);
    }

    /**
     * Validate account code.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function validatorCode(Request $request)
    {   
        $id     =   $request->input('id');
        $code   =   $request->input('code');  

        if (isset($id)) {
            $count  =   Account::where('id', '<>', $id)->where('code',$code)->count();    
        }else{
            $count  =   Account::where('code', $code)->count();   
        }
        
        if($count != 0)
        {
            return Response()->json(false);
        }

        return Response()->json(true);
    }
}