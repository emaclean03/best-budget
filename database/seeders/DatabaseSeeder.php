<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Account;
use App\Models\Budget;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\User;
use Cknow\Money\Money;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::factory(1)->create(['email' => 'emaclean03@aol.com']);

        $budget = Budget::factory()->create([
            'user_id'=>$user->first()->id
        ]);

            $categories = [
                'Mortgage',
                'Cell',
                'School',
                'Transportation',
                'Car Insurance',
                'Florida 529',
                'Electric',
                'Dog foods',
                'Dining out',
                'Fun Money',
            ];

        //Create categories
        foreach ($categories as $categoryName){
            $category = Category::factory()->make(
                [
                    'user_id' => $user->first()->id,
                    'budget_id'=>$budget->id,
                    'category_name' => $categoryName
                ]
            );

            $budget->categories()->save($category);
        }



        //Make an account
        $account = Account::factory()->make(
            [
                'user_id' => $user->first()->id,
                'budget_id'=>$budget->id,
                'working_balance'=> Money::USD(220000)
            ]
        );

        $budget->account()->save($account);

        //Transactions
        $transaction = Transaction::factory()->make(
            [
                'user_id'=>$user->first()->id,
                'budget_id'=>$budget->first()->id,
                'account_id'=>$account->first()->id,
                'category_id'=>Category::first()->id,
            ]
        );

        $account->transaction()->save($transaction);

    }
}
