<?php

namespace Tests\Feature\Account\Transactions;

use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
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
            'user_id'=>$this->user->id
        ]);
        $this->account = Account::factory()->create([
            'user_id'=> $this->user->id,
            'budget_id'=>$this->budget->id,
        ]);

        Category::factory()->create([
            'user_id'=>$this->user->id,
            'budget_id'=>$this->budget->id,
        ]);

    }

    public function test_getTransactionsPage()
    {
        Transaction::factory()->create([
            'user_id'=>$this->user->id,
            'budget_id'=>$this->budget->id,
            'account_id'=>$this->account->id,
            'category_id'=>1
        ]);

        $response = $this->get('/account/1');

        $response->assertInertia(fn ($page) => $page
            ->component('Account/Account')
            ->has('transactions', 1)
        );

        $response->assertStatus(200);
    }

    public function test_Can_Save_New_Transaction(){
        Transaction::factory()->make([
            'user_id'=>$this->user->id,
            'budget_id'=>$this->budget->id,
            'account_id'=>$this->account->id,
            'category_id'=>1
        ]);


    }
}
