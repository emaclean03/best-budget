<?php

namespace App\Actions\Fortify;

use App\Models\Budget;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        $user =  User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        //Let's create a budget when a user is registered
        //And we can fill it in with default categories
       $budget = Budget::make([
           'budget_name'=> 'Your first budget'
       ]);



        $user->budget()->save($budget);
        //$budget->categories()->save($category);

        $categories = [
            'Assign Income',
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
        foreach ($categories as $categoryName) {
            $category = Category::factory()->make(
                [
                    'user_id' => $user->id,
                    'budget_id' => $budget->id,
                    'currency' => 'USD',
                    'category_name' => $categoryName
                ]
            );

            $budget->categories()->save($category);
        }


        return $user;

    }
}
