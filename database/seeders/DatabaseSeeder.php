<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
     
        User::factory(10)->create();

         $user1 = User::factory()->create([
             'name' => 'Admin',
             'email' => 'admin@example.com',
             'password' => Hash::make('aaaaaaaa'),
         ]);
        
        // Create roles 
        $adminRole = Role::create(['name' => 'Admin', 'guard_name' => 'api']);
        //Assign roles to the users
        $user1->assignRole($adminRole);
      
}
}