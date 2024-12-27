<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "email" => "manager@test.com",
            "role" => 'manager',
            "password" => Hash::make("12345678"),
        ]);

        User::create([
            "email" => "employee@test.com",
            "role" => 'employee',
            "password" => Hash::make("12345678"),
        ]);
    }
}
