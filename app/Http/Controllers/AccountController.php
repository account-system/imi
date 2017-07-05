<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Helpers\Status;
use App\Transaction;
use App\TransactionDetail;
use Carbon\Carbon;
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
    public function getAccountListByAccountType($id = null, $option = null)
    {
        $accounts = [];

        if ($option == 'dropdownlist') {
            $accounts = Account::where('account_type_id', $id)->where('status',Status::ACTIVE)->get(['id', 'code', 'name'])->sortBy('code')->values()->all();
        }elseif ($option == 'foriegnkeycolumn') {
            $accounts = Account::where('account_type_id', $id)->get(['id as value','name as text'])->sortBy('text')->values()->all(); 
        }elseif ($option == 'all') {
            $accounts = Account::where('account_type_id', $id)->get()->sortByDesc('id')->values()->all();
        }
        
        return Response()->Json($accounts);
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
            $accounts = DB::table('accounts')->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')->select('accounts.id as accountId', 'accounts.code as accountCode', 'Accounts.name as accountName', 'Accounts.account_type_id as accountTypeId', 'account_types.name as accountTypeName')->where('accounts.status', Status::ACTIVE)->orderBy('accountName', 'asc')->get();
        }elseif($option == 'foriegnkeycolumn'){
             $accounts = DB::table('accounts')->join('account_types', 'accounts.account_type_id', '=', 'account_types.id')->select('accounts.id as accountId', 'accounts.code as accountCode', 'Accounts.name as accountName', 'Accounts.account_type_id as accountTypeId', 'account_types.name as accountTypeName')->orderBy('accountName', 'asc')->get();
        }elseif($option == 'all'){
            $accounts = Account::all()->sortByDesc('id')->values()->all();;
        }

        return Response()->Json($accounts);
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

        /*Transaction type id(Journal Entry)*/
        $journalEntryTransactionTypeId = 11;

        /*Opening balance equity account id*/
        $openingBalanceEquityAccountId = 1;

        /*Account type ids(Bank, Other Current Asset, Fixed Asset, Other Asset) in debit value*/
        $debitInAccountTypeIds = [1, 3, 4, 5];

        /*Account type ids(Other Current Liability, Long Term Liability, Equity) in credit value*/
        $creditInAccountTypeIds=  [7, 8, 9];

        /*Account type ids debit and credit value*/
        $accountIds = array_merge($debitInAccountTypeIds, $creditInAccountTypeIds);

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

                /*Check account type can be opening balance*/
                if(in_array($accountRequest->account_type_id, $accountIds)) {
                    /*Check balance is greater than zero*/
                    if($accountRequest->balance > 0){

                        $transaction = New Transaction();

                        $transaction->transaction_type_id   =   $journalEntryTransactionTypeId;
                        $transaction->amount                =   $accountRequest->balance;
                        $transaction->date                  =   Carbon::parse($accountRequest->balance_date)->addDay();
                         $transaction->branch_id            =   $accountRequest->branch_id;
                        $transaction->created_by            =   auth::id();
                        $transaction->updated_by            =   auth::id();

                        $transaction->save();

                        $journalEntryData   =   array(
                            array( 
                                'transaction_id'    =>  $transaction->id,
                                'account_id'        =>  $accountObject->id,
                                'amount'            =>  $accountRequest->balance,
                                'memo'              =>  "Opening Balance",
                                'created_by'        =>  auth::id(),
                                'updated_by'        =>  auth::id()
                            ),
                            array(
                                'transaction_id'    =>  $transaction->id,
                                'account_id'        =>  $openingBalanceEquityAccountId,
                                'amount'            =>  $accountRequest->balance,
                                'memo'              =>  "Opening Balance",
                                'created_by'        =>  auth::id(),
                                'updated_by'        =>  auth::id()
                            )
                        );

                        if (in_array($accountRequest->account_type_id, $debitInAccountTypeIds)) {
                            $journalEntryData[0]['debit'] = $accountRequest->balance;
                            $journalEntryData[1]['credit'] = $accountRequest->balance;
                        }elseif (in_array($accountRequest->account_type_id, $creditInAccountTypeIds)) {
                            $journalEntryData[0]['credit'] = $accountRequest->balance;
                            $journalEntryData[1]['debit'] = $accountRequest->balance;  
                        }

                        TransactionDetail::create($journalEntryData[0]);
                        TransactionDetail::create($journalEntryData[1]);
                    }

                }
                

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
            $accountTypes = AccountType::where('status', Status::ACTIVE)->get(['id as accountTypeId', 'min_code as minCode', 'max_code as maxCode', 'name as accountTypeName'])->all();
        }elseif($option == 'foriegnkeycolumn'){
             $accountTypes = AccountType::get(['id as value','name as text'])->all();  
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
