<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Cknow\Money\Money;
use Illuminate\Support\Facades\Log;


class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \App\Http\Requests\StoreTransactionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTransactionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateTransactionRequest $request
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        /*
         * Updating Category
         *
         * */

        if ($request->filled('memo')) {
            $transaction->update([
                'memo' => $request->memo
            ]);
        } else if ($request->filled('payee')) {
            $transaction->update([
                'payee' => $request->payee
            ]);
        } elseif ($request->filled('category')) {
            //TODO:Need to update the activity amount going from old->new category
            $transaction->update([
                'category_id' => $request->category
            ]);
        } elseif ($request->filled('outflow')) {
            $outflow_parse = Money::parse($request->outflow);

            $transaction->update([
                'outflow' => $outflow_parse,
            ]);



            $transaction->refresh();

            $transaction_outflow_sum = Money::USD($transaction->sum('outflow'));

            $transaction->category()->update([
                'category_available' => Money::USD($transaction->category->category_assigned)->subtract($transaction_outflow_sum)->formatByDecimal(),
            ]);

            $transaction->refresh();
            $transaction->category()->update([
                'category_activity' => Money::USD($transaction->category->category_assigned)
                    ->subtract($transaction->category->category_available)
                    ->negative()
                    ->formatByDecimal(),
            ]);

            //Update total budget amount

        } elseif ($request->filled('inflow')) {
            //Update ready to be budgeted
            //Update accounts.working_balance
            $parsed_inflow = Money::parse($request->inflow);
            $transaction->update([
                'inflow' => $parsed_inflow
            ]);

            $transaction->account()->update([
                'working_balance'=> Money::USD($transaction->account->working_balance)->add($parsed_inflow)->formatByDecimal(),
            ]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Transaction $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
