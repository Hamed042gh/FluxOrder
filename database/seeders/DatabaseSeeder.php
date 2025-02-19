<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
    
         Order::factory(20)->create();
        // ایجاد نقش‌ها برای گارد api
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'api']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'api']);

        // تعریف پرمیژن‌ها
        $manageUsers = Permission::create(['name' => 'manage_users', 'guard_name' => 'api']);
        $viewOrders = Permission::create(['name' => 'view_orders', 'guard_name' => 'api']);
        $editOrders = Permission::create(['name' => 'edit_orders', 'guard_name' => 'api']);

        // اختصاص پرمیژن‌ها به رول‌ها
        $adminRole->givePermissionTo([$manageUsers, $viewOrders, $editOrders]); // پرمیژن‌های مربوط به admin
        $userRole->givePermissionTo([$viewOrders]); // فقط view_orders به user داده میشه
        }
}
