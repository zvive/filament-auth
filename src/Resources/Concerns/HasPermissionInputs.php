<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\Concerns;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use FilamentAuth\Concerns\HasFilamentAuth;

trait HasPermissionInputs
{
    use HasFilamentAuth;

    public static function getInputs()
    {
        $inputs = [
            TextInput::make('name')
                ->label((string) (\__('filament-auth::filament-auth.field.name'))),
        ];

        if (static::authPackage() === 'bouncer') {
            $inputs = \array_merge($inputs, [
                TextInput::make('title')
                    ->label('Title'),
                TextInput::make('entity_name')
                    ->label('Entity Name'),
                TextInput::make('scope')
                    ->label('Scope')
                    ->tooltip('Only needed for multitenancy'),
                Toggle::make('only_owned')->label('Only Owned')->default(true),
            ]);
        }

        if (static::authPackage() === 'laravel-permission') {
            $inputs = \array_merge($inputs, [
                TextInput::make('guard_name')
                    ->label((string) (\__('filament-auth::filament-auth.field.guard_name')))
                    ->default(\config('auth.defaults.guard')),
                // BelongsToManyMultiSelect::make('roles')
                //     ->label(strval(__('filament-auth::filament-auth.field.roles')))
                //     ->relationship('roles', 'name')
                //     ->preload(config('filament-spatie-roles-permissions.preload_roles'))
            ]);
        }

        return $inputs;
    }
}
