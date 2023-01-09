<?php

namespace Tests\Feature\Transactions;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    private $budget;
    private $account;
    private $category;

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

        $this->category = Category::factory()->create([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
        ]);

    }

    public function test_getTransactionsPage()
    {

        Transaction::factory()->create([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
            'account_id' => $this->account->id,
            'category_id' => $this->category->id,
        ]);

        $response = $this->get('/account/'.$this->account->id);

        $this->assertDatabaseCount('transactions', 1);

        $response->assertStatus(200);
    }

   /* public function test_Can_Save_New_Transaction()
    {
        Transaction::factory()->make([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
            'account_id' => $this->account->id,
            'category_id' => 1
        ]);
    }*/

    public function test_adding_new_transaction_updates_available_column()
    {
        $transaction = Transaction::factory()->make([
            'user_id' => $this->user->id,
            'budget_id' => $this->budget->id,
            'account_id' => $this->account->id,
            'transaction_category' => ['id' => $this->category->id],
            'transaction_type' => 'outflow',
            'transaction_amount' => 150.00
        ]);


        $this->post('/transaction/store', $transaction->toArray());


        $this->assertDatabaseHas('categories',
            [
                'category_available' => -150.00
            ]);


    }
}
