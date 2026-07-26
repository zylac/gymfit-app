<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\MembershipPlan;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'Admin']);
        $ptRole = Role::create(['name' => 'PT']);
        $memberRole = Role::create(['name' => 'Member']);

        // Create Admin
        $admin = User::create([
            'name' => 'Admin GymFit',
            'email' => 'admin@gymfit.com',
            'password' => Hash::make('password'),
        ]);
        $admin->assignRole($adminRole);

        // Create PT
        $pt = User::create([
            'name' => 'Trainer Agung',
            'email' => 'trainer@gymfit.com',
            'password' => Hash::make('password'),
        ]);
        $pt->assignRole($ptRole);

        // Create Member
        $member = User::create([
            'name' => 'Agung Student',
            'email' => 'agung@student.com',
            'password' => Hash::make('password'),
        ]);
        $member->assignRole($memberRole);

        // Create Plans
        MembershipPlan::create([
            'name' => 'Basic Plan 1 Bulan',
            'description' => 'Akses Gym 1 Bulan',
            'price' => 150000,
            'duration_days' => 30,
        ]);

        MembershipPlan::create([
            'name' => 'Pro Plan 3 Bulan + 4 Sesi PT',
            'description' => 'Akses Gym 3 Bulan dan 4x sesi Personal Trainer',
            'price' => 500000,
            'duration_days' => 90,
        ]);
    }
}
