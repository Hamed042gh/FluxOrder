<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\NewUserRegistered;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        
        $admins = User::role(['َAdmin','SuperAdmin'])->get(); 

        
            Notification::make('greeting')
                ->title('User Registration')
                ->body($user->name.'Registered')
                ->info()
                ->persistent()
                ->sendToDatabase($admins);
        
       
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
