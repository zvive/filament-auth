<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\Concerns;

use Filament\Forms\Components\TextInput;
use FilamentAuth\Concerns\HasFilamentAuth;

trait HasRoleInputs
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
                TextInput::make('scope')
                    ->label('Scope')
                    ->tooltip('Only needed for multitenancy'),
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
