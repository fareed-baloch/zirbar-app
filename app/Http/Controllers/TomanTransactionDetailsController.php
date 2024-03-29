<?php

namespace App\Http\Controllers;

use App\Models\TomanTransactionDetails;
use App\Http\Controllers\Controller;
use App\Models\TomanTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class TomanTransactionDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tomanTransaction = TomanTransaction::find($id);
        $tomanTransactionDetails = TomanTransactionDetails::where('transactionid', $id)->get();
        $remainingFunds = $tomanTransaction->toman;
        foreach ($tomanTransactionDetails as $row) {
            $remainingFunds -= $row->amount;
        }
        return view('pages.toman_transaction_details.index', ['tomanTransaction' => $tomanTransaction, 'tomanTransactionDetails' => $tomanTransactionDetails, 'remainingFunds' => $remainingFunds]);
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
    public function store(Request $request)
    {
        $tomanTransaction = TomanTransaction::find($request->transactionid);
        $tomanTransactionDetails = TomanTransactionDetails::where('transactionid', $request->transactionid)->get();
        
        $remainingFunds = $tomanTransaction->toman;
        foreach ($tomanTransactionDetails as $row) {
            $remainingFunds -= $row->amount;
        }

        if($request->amount > $remainingFunds) {
            return Redirect::back()->with('danger', 'Remaining toman are '.$remainingFunds);
        }
        $table = new TomanTransactionDetails();
        $table->transactionid = $request->transactionid;
        $table->stockerid = $request->stockerid;
        $table->type = $tomanTransaction->type; // 1 purchased 2 sell
        $table->amount = $request->amount; // toman amount
        $table->date = $request->date; // toman amount
        $table->save();
        return Redirect::back()->with('success', 'Toman Transaction Detail Added');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function show(TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TomanTransactionDetails $tomanTransactionDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TomanTransactionDetails  $tomanTransactionDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $table = TomanTransactionDetails::find($request->id);
        $table->delete();
        return Redirect::back()->with('danger', 'Detail Removed');
    }
}
