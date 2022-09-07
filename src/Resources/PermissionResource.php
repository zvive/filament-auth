<?php

declare(strict_types=1);

namespace FilamentAuth\Resources;

use FilamentAuth\Resources\PermissionResource\Pages\CreatePermission;
use FilamentAuth\Resources\PermissionResource\Pages\EditPermission;
use FilamentAuth\Resources\PermissionResource\Pages\ListPermissions;
use FilamentAuth\Resources\PermissionResource\Pages\ViewPermission;
use FilamentAuth\Resources\PermissionResource\RelationManager\RoleRelationManager;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Grid;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use FilamentAuth\Resources\Concerns\HasPermissionInputs;
use FilamentAuth\Resources\Concerns\HasPermissionColumns;

class PermissionResource extends Resource
{
    use HasPermissionInputs;
    use HasPermissionColumns;
    protected static ?string $navigationIcon = 'heroicon-o-lock-closed';

    public static function getModel() : string
    {
        return static::filamentAuth()->getPermissionClass();
    }

    public static function getLabel() : string
    {
        return (string) (\__('filament-auth::filament-auth.section.permission'));
    }

    protected static function getNavigationGroup() : ?string
    {
        return (string) (\__('filament-auth::filament-auth.section.group'));
    }

    public static function getPluralLabel() : string
    {
        return (string) (\__('filament-auth::filament-auth.section.permissions'));
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        Grid::make(2)->schema(
                            static::getInputs(),
                        ),
                    ]),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table->columns(static::getColumns());
    }

    public static function getRelations() : array
    {
        return [
            RoleRelationManager::class,
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => ListPermissions::route('/'),
            'create' => CreatePermission::route('/create'),
            'edit'   => EditPermission::route('/{record}/edit'),
            'view'   => ViewPermission::route('/{record}'),
        ];
    }
}
