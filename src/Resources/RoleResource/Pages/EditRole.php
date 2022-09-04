<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\RoleResource\Pages;

use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\EditRecord;

class EditRole extends EditRecord
{
    use Concerns\UpdatesRole;

    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.RoleResource');
    }
}
