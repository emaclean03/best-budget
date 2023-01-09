<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Cknow\Money\Money;

class AccountController extends Controller
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
     * @param \App\Http\Requests\StoreAccountRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAccountRequest $request)
    {
        $account = Account::make([
            'budget_id' => Auth::user()->budget->id,
            'account_name' => $request->accountName,
            'account_type' => $request->accountType,
            'currency' => 'USD',
        ]);

        Auth::user()->account()->save($account);


        //Add new income to our working balance
        $account->update([
            'working_balance'=> Money::USD($account->working_balance)->add(Money::USD($request->startingBalance)),
        ]);

        //Create the income transaction
        $amountToAssignCategory = Category::where('category_name', '=', 'Assign Income')->where('user_id', Auth::user()->id)->first();
         Transaction::create([
            'user_id'=>Auth::user()->id,
            'budget_id' => Auth::user()->budget->id,
            'account_id' => $account->id,
            'category_id' => $amountToAssignCategory->id,
            'inflow' => Money::USD($request->startingBalance)->getAmount(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Account $account
     * @return \Inertia\Response
     */
    public function show(Account $account)
    {
        return Inertia::render('Account/Account', [
            'account' => $account,
            'transactions' => $account->transaction()->with('category')->get(),
            'categories' => Auth::user()->category()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function edit(Account $account)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateAccountRequest $request
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAccountRequest $request, Account $account)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Account $account
     * @return \Illuminate\Http\Response
     */
    public function destroy(Account $account)
    {
        //
    }
}
