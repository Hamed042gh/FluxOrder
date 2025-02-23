<?php

namespace App\Filament\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\User;
use Filament\Tables\Columns\TextColumn;


class TableUsersWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(User::role('Admin'))
            ->heading('Admin Users') 
            ->columns([
                TextColumn::make('name') 
                    ->label('User Name'), 
                TextColumn::make('email')
                    ->label('Email'),
            ]);
    }
}
