<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;
use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';
    protected static ?string $navigationGroup = 'Roles & Permissions';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([Fieldset::make()->schema([
              Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->maxLength(255),
                Select::make('permissions')
                ->multiple()
                ->relationship('permissions','name')
                ->preload()
            ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([Tables\Columns\TextColumn::make('id')
                ->label('Id')
                ->sortable(),
              Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d-M-Y')
                ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
        ];
    }

    // public static function getEloquentQuery(): Builder
    // {
    //   $user = Auth::user();
    //     if
    //     ($user->hasRole('SuperAdmin') ) {
    //         // اگر کاربر ادمین است، همه رکوردها نمایش داده می‌شود
    //         return parent::getEloquentQuery();
    //     } else {
    //         // اگر کاربر ادمین نیست، رکوردهایی که نامشان با 'Admin' یا 'User new' است فیلتر می‌شود
    //         return parent::getEloquentQuery()->whereNotIn('name', ['Admin', 'User new']);
    //     }
    // }

}
