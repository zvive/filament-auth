<?php

declare(strict_types=1);

namespace FilamentAuth\Resources;

use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use FilamentAuth\Resources\Concerns\HasRoleInputs;
use FilamentAuth\Resources\Concerns\HasRoleColumns;
use FilamentAuth\Resources\RoleResource\Pages\EditRole;
use FilamentAuth\Resources\RoleResource\Pages\ViewRole;
use FilamentAuth\Resources\RoleResource\Pages\ListRoles;
use FilamentAuth\Resources\RoleResource\Pages\CreateRole;
use FilamentAuth\Resources\RoleResource\RelationManager\PermissionRelationManager;

class RoleResource extends Resource
{
    use HasRoleColumns;
    use HasRoleInputs;
    protected static ?string $slug = 'roles';

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    

    public static function getModel() : string
    {
        return static::filamentAuth()->getRoleClass();
    }

    public static function getLabel() : string
    {
        return (string) (__('filament-auth::filament-auth.section.role'));
    }

    protected static function getNavigationGroup() : ?string
    {
        return (string) (__('filament-auth::filament-auth.section.group'));
    }

    public static function getPluralLabel() : string
    {
        return (string) (__('filament-auth::filament-auth.section.roles'));
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)
                            ->schema(static::getInputs()),
                    ]),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters([
                //
            ]);
    }

    public static function getRelations() : array
    {
        return [
            PermissionRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'edit'   => EditRole::route('/{record}/edit'),
            'view'   => ViewRole::route('/{record}'),
        ];
    }
}
