<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\PermissionResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;

class EditPermission extends EditRecord
{
    use Concerns\UpdatesPermission;

    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.PermissionResource');
    }
}
