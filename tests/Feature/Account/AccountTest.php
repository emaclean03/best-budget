<?php

namespace Tests\Feature\Account;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountTest extends TestCase
{
    use RefreshDatabase;

    private $budget;
    private $account;

    public function setUp(): void
    {
        parent::setUp();
        /*Log in as user as this will all be behind the log in wall*/
        $this->user = User::factory()->create();
        $this->actingAs($this->user);
        $this->budget = Budget::factory()->create([
            'user_id' => $this->user->id
        ]);
        $this->account = Account::factory()->create([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
        ]);

        Category::factory()->create([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
        ]);

    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_starting_balance_transaction_created_on_account_creation()
    {
        $account = Account::factory()->make(
            [
                'accountName'=>'PNC Joint',
                'accountType'=>'Checking',
                'startingBalance'=>150.00
            ]
        );

        $response = $this->post('/account/store', $account->toArray());

        $this->assertDatabaseHas('transactions', [
            'inflow'=>$account->startingBalance
        ]);

        $response->assertStatus(200);
    }
}
