<?php

use App\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'id' => 1,
                'name' => 'Administrator',
            ],
            [
                'id' => 2,
                'name' => 'User'
            ]
        ];

        Role::insert($roles);
    }
}
