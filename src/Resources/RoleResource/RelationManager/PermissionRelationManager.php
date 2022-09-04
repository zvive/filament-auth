<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\RoleResource\RelationManager;

use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use FilamentAuth\Resources\Concerns\HasPermissionInputs;
use FilamentAuth\Resources\Concerns\HasPermissionColumns;

class PermissionRelationManager extends RelationManager
{
    use HasPermissionInputs;
    use HasPermissionColumns;
    protected static string $relationship          = 'permissions';
    protected static ?string $recordTitleAttribute = 'name';

    public function __construct()
    {
        static::$relationship = static::authPackage() === 'laravel-permissions' ? 'permissions' : 'abilities';
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema(static::getInputs());
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
