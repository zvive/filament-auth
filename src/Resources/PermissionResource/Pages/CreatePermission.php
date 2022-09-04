<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\PermissionResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\CreateRecord;

class CreatePermission extends CreateRecord
{
    use Concerns\UpdatesPermission;

    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.PermissionResource');
    }
}
