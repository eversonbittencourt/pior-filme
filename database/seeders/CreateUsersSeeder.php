<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        $users = [
            [
                'first_name' => 'Everson',
                'last_name' => 'Bittencourt',
                'name' => 'everson',
                'email' => 'bittencourt.everson@gmail.com',
                'password' => Hash::make('12345')
            ]
        ];

        foreach ( $users as $user ) {
            User::updateOrCreate(
                [ 'email' => $user['email'] ],
                $user
            );
        } 
    }
}
