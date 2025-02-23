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
     
     
        Permission::create(['name' => 'create-orders']);
        Permission::create(['name' => 'read-orders']);
        Permission::create(['name' => 'update-orders']);
        Permission::create(['name' => 'delete-orders']);

        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        $user = User::factory()->create([
            'password' => Hash::make('password123'),
        ]);

        $user->assignRole($adminRole);

        Order::factory(10)->create();
    
}
}