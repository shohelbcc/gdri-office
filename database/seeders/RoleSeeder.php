<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'super admin'
            ],
            [
                'name' => 'admin'
            ],
            [
                'name' => 'employee'
            ],
        ];

        foreach ($roles as $key => $value) {
            Role::create($value);
        }

        $user1 = User::find(1);
        $role1 = Role::where('name', 'super admin')->first();
        $user1->roles()->attach($role1);

        $user2 = User::find(2);
        $role2 = Role::where('name', 'admin')->first();
        $user2->roles()->attach($role2);

        $users = User::whereNotIn('id', [1,2])->get();
        $role5 = Role::where('name', 'employee')->first();
        foreach ($users as $key => $user) {
            $user->roles()->attach($role5);
        }        
    }
}
