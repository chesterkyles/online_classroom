<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 20)->create()->each(function ($user) {
            $user->getAccountModel()->create([
                'account_number' => $user->account_number,
                'firstname' => $user->firstname,
                'lastname' => $user->lastname,
            ]);
        });
    }
}
