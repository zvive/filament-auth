<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\Concerns;

use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Columns\TextColumn;
use FilamentAuth\Concerns\HasFilamentAuth;

trait HasPermissionColumns
{
    use HasFilamentAuth;

    public static function getColumns()
    {
        $columns = [
            TextColumn::make('id')
                ->label('ID')
                ->searchable(),
            TextColumn::make('name')
                ->label((string) (\__('filament-auth::filament-auth.field.name')))
                ->searchable(),
        ];
        if (static::authPackage() === 'bouncer') {
            $columns = \array_merge($columns, [
                TextColumn::make('title')
                    ->label((string) (\__('filament-auth::filament-auth.field.title')))
                    ->searchable(),
                TextColumn::make('entity_type')
                    ->label('Entity type')
                    ->searchable(),
                TextColumn::make('scope')
                    ->label('Scope')
                    ->tooltip('Only needed for multitenancy')
                    ->searchable(),
                BooleanColumn::make('only_owned')->label('Owned only'),
            ]);
        }
        if (static::authPackage() === 'laravel-permission') {
            $columns = \array_merge($columns, [
                TextColumn::make('guard_name')
                    ->label((string) (\__('filament-auth::filament-auth.field.guard_name')))
                    ->searchable(),
            ]);
        }

        return $columns;
    }
}
