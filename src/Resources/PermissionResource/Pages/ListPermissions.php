<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\PermissionResource\Pages;

use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Actions\BulkAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Collection;
use FilamentAuth\FilamentAuth;

class ListPermissions extends ListRecords
{
    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.PermissionResource');
    }

    protected function getTableBulkActions() : array
    {
        $auth      = \app(FilamentAuth::class);
        $roleClass = $auth->getRoleModel();

        return [
            BulkAction::make('Attach Role')
                ->action(function (Collection $permissions, array $data) use ($auth) : void {
                    if ($auth->authPackage() === 'laravel-permission') {
                        foreach ($permissions as $permission) {
                            $permission->roles()->sync($data['role']);
                            $permission->save();
                        }
                    }
                    if ($auth->authPackage() === 'bouncer') {
                        foreach ($permissions as $permission) {
                            $auth->bouncer()->sync($permission)->roles($data['role']);
                        }
                    }
                })
                ->form([
                    Select::make('role')
                        ->label((string) (\__('filament-auth::filament-auth.field.role')))
                        ->options((new $roleClass())::query()->pluck('name', 'id'))
                        ->required(),
                ])->deselectRecordsAfterCompletion(),
        ];
    }
}
