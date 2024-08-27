<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $fakeUsers = User::factory(10)->make(); // only make without push it to the DB
        // User::factory(3)->create(); //make then create it in the DB
        /* ==
        User::factory()->count(10)->create();
        */

        UserFactory::new()->count(3)->create();
    }
}
