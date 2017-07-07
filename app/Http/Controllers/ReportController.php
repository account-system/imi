<?php

namespace App\Http\Controllers;

use App\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
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
     * Display a listing of the journal resport.
     *
     * @return \Illuminate\Http\Response
     */
    public function journal(Request $request)
    {
        $this->data['title'] = 'Journal';

        return view('pages.reports.journal', $this->data);
    }

    /**
     * Get a listing of the journal resport.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function getJournal(Request $request)
    {
        $dateMacro 	=	$request->input('date_macro');
        $lowDate	= 	Carbon::parse($request->input('low_date'))->format('Y-m-d');
        $highDate	=	Carbon::parse($request->input('high_date'))->format('Y-m-d');

        if($dateMacro == 'all'){
        	$journals = Transaction::all();	
        }else{
        	$journals = Transaction::where('date', '>=', $lowDate)->where('date', '<=', $highDate)->get();
        }
        
        $journalReports = $journalReport = [];

        foreach ($journals as $key => $journal) {

            $journalDetails = $journal->transactionDetails()->get();

            foreach ($journalDetails as $key => $journalDetail) {
                if($key == 0){
                    $journalReport['id']                =   $journal->id;
                    $journalReport['date']              =   $journal->date;
                    $journalReport['transactionType']   =   $journal->TransactionType->name;
                    $journalReport['referenceNumber']   =   $journal->reference_number;
                    $journalReport['name']              =   null;
                    $journalReport['memo']              =   $journal->memo;
                    $journalReport['account']           =   $journalDetail->account->name;
                    $journalReport['debit']             =   $journalDetail->debit;
                    $journalReport['credit']            =   $journalDetail->credit;
                    $journalReport['createdBy']         =   null;
                    $journalReport['updatedBy']         =   null;
                    $journalReport['createdAt']         =   $journal->created_at;
                    $journalReport['updatedAt']         =   $journal->updated_at;
                    
                }else{
                    $journalReport['id']                =   $journalDetail->transaction_id;
                    $journalReport['date']              =   null;
                    $journalReport['transactionType']   =   null;
                    $journalReport['referenceNumber']   =   null;
                    $journalReport['name']              =   null;
                    $journalReport['memo']              =   $journalDetail->memo;
                    $journalReport['account']           =   $journalDetail->account->name;
                    $journalReport['debit']             =   $journalDetail->debit;
                    $journalReport['credit']            =   $journalDetail->credit;
                    $journalReport['createdBy']         =   null;
                    $journalReport['updatedBy']         =   null;
                    $journalReport['createdAt']         =   null;
                    $journalReport['updatedAt']         =   null;  
                }

                $journalReports[] = $journalReport;
            }
        }

        return Response()->Json($journalReports);
    }
}
