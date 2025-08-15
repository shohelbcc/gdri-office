<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Shohel Rana',
                'phone' => '01942034788',
                'email' => 'advsukanto@gmail.com',
                'user_type' => 'admin',
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Mariam Binte Shohel',
                'phone'=> '01942034789',
                'email' => 'mariam@gmail.com',
                'user_type' => 'admin',
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Sadia Rahman',
                'phone'=> '01942034790',
                'email' => 'sadia@gmail.com',
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034791',
                'email' => 'shamim@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034792',
                'email' => 'shamim9@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034793',
                'email' => 'shamim2@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034794',
                'email' => 'shamim4@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034795',
                'email' => 'shamim3@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
            [
                'name' => 'Shamim Ahmed',
                'phone'=> '01942034796',
                'email' => 'shamim5@gmail.com',
                
                'password'=> Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            $user = User::create($userData);

            UserProfile::create([
                'user_id' => $user->id,
                'photo' => null,
                'address' => null,
                'division' => null,
                'thana' => null,
                'postal_code' => null,
            ]);
        }
    }
}
