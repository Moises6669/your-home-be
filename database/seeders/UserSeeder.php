<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $regularUser = User::factory()->create([
            'email' => 'user@example.com',
        ]);

        $sellerUser = User::factory()->create([
            'email' => 'seller@example.com',
        ]);

        $adminUser = User::factory()->create([
            'email' => 'admin@example.com',
        ]);

        $regularRole = Role::where('role_name','user_regular')->first();
        $sellerRole = Role::where('role_name','user_regular')->first();
        $adminRole = Role::where('role_name','user_regular')->first();

        $regularUser->roles()->attach($regularRole);
        $sellerUser->roles()->attach($sellerRole);
        $adminUser->roles()->attach($adminRole);
    }
}
