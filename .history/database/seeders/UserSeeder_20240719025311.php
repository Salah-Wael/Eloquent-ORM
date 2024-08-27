<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $User::factory(10)->make(); // only make without push it to the DB
        // User::factory(10)->create(); //make then create it in the DB
        /* ==
        User::factory()->count(10)->create();
        */
    }
}
