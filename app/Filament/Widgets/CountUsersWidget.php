<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CountUsersWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $users_count = \App\Models\User::count();
        $admin_count = \App\Models\User::role('Admin')->count(); // Assuming the role is 'admin'
        $superadmin_count = \App\Models\User::role('SuperAdmin')->count();

        return [
            Stat::make('Total Users', $users_count),
            Stat::make('Admins', $admin_count),
            Stat::make('SuperAdmins', $superadmin_count),
        ];
    
    }
}
