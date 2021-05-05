<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserEmployeeSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@example.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'role' => 2 //2 = Employee
        ]);

        User::factory(10)->create();
    }
}
