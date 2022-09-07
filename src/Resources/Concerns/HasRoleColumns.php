<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\Concerns;

use Filament\Tables\Columns\TextColumn;
use FilamentAuth\Concerns\HasFilamentAuth;

trait HasRoleColumns
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
                TextColumn::make('scope')
                    ->label('Scope')
                    ->tooltip('Only needed for multitenancy')
                    ->searchable(),

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
