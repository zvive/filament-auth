<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\RoleResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\CreateRecord;

class CreateRole extends CreateRecord
{
    use Concerns\UpdatesRole;

    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.RoleResource');
    }
}
