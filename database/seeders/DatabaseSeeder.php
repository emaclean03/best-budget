<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
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


        //Create categories
        $category = Category::factory()->make(
            [
                'user_id' => $user->first()->id,
                'budget_id'=>$budget->id,
            ]
        );

        $budget->categories()->save($category);


    }
}
