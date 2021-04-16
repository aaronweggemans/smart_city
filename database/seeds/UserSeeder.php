<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default password for all
        $password = Hash::make('Heelgeheim123');

        // Creates a array with values for our login system
        $importable_users = [
            [
                'name' => 'Aaron Weggemans',
                'role_id' => 1,
                'email_verified_at' => now(),
                'email' => 'aaronweggemans@hotmail.nl',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Alex Yip',
                'role_id' => 1,
                'email_verified_at' => now(),
                'email' => 'alexyip@hotmail.nl',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Christian Tol',
                'role_id' => 1,
                'email_verified_at' => now(),
                'email' => 'christiantol@hotmail.nl',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
            [
                'name' => 'Jovanni Tjon-A-Sam',
                'role_id' => 1,
                'email_verified_at' => now(),
                'email' => 'jovannitjonasam@hotmail.nl',
                'password' => $password,
                'remember_token' => Str::random(10),
            ],
        ];

        // Calls the factory for dummy users
        factory(User::class, 10)->create();

        // Imports our users
        User::insert($importable_users);
    }
}
