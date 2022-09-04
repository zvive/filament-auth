<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\PermissionResource\RelationManager;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
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
            ->schema(
                static::getInputs()
            );
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters([
                //
            ]);
    }
}
