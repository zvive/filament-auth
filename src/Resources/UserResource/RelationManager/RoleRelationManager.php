<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\UserResource\RelationManager;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use FilamentAuth\Resources\Concerns\HasRoleColumns;
use FilamentAuth\Resources\Concerns\HasRoleInputs;

class RoleRelationManager extends RelationManager
{
    use HasRoleColumns;
    use HasRoleInputs;
    protected static string $relationship          = 'roles';
    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label((string) (\__('filament-auth::filament-auth.field.name'))),
                TextInput::make('guard_name')
                    ->label((string) (\__('filament-auth::filament-auth.field.guard_name')))
                    ->default(\config('auth.defaults.guard')),

            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label((string) (\__('filament-auth::filament-auth.field.name')))
                    ->searchable(),
                TextColumn::make('guard_name')
                    ->label((string) (\__('filament-auth::filament-auth.field.guard_name'))),

            ])
            ->filters([
                //
            ]);
    }
}
