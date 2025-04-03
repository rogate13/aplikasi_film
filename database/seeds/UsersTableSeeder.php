<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\User;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['username' => 'aldmic'],
            ['password' => Hash::make('123abc123')]
        );
    }
}
