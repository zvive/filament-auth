<?php

declare(strict_types=1);

namespace FilamentAuth;

use Exception;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Contracts\Auth\Authenticatable;

class FilamentAuth
{
    // Default Classes.
    public const SPATIE_PERMISSION_CONTRACT  = '\\Spatie\\Permission\\Contracts\\Permission';
    public const SPATIE_PERMISSION_MODEL     = '\\Spatie\\Permission\\Models\\Permission';
    public const SPATIE_PERMISSION_REGISTRAR = '\\Spatie\\Permission\\PermissionRegistrar';
    public const SPATIE_ROLE_CONTRACT        = '\\Spatie\\Permission\\Contracts\\Role';
    public const SPATIE_ROLE_MODEL           = '\\Spatie\\Permission\\Models\\Role';
    public const BOUNCER_MAIN_CLASS          = '\\Silber\\Bouncer\\Bouncer';
    public const BOUNCER_ROLE_MODEL          = '\\Silber\\Bouncer\\Database\\Role';

    // called Ability, using PERMISSION for congruity.
    public const BOUNCER_PERMISSION_MODEL = 'Silber\\Bouncer\\Database\\Ability';

    public function authPackage()
    {
        return \config('filament-auth.permission_package');
    }

    public function getPermissionClass()
    {
        return \fa_get_auth_model('permission');
    }

    public function getRoleClass()
    {
        return \fa_get_auth_model('role');
    }

    public function bouncer()
    {
        if (\class_exists(static::BOUNCER_MAIN_CLASS)) {
            return \app(static::BOUNCER_MAIN_CLASS);
        }
        throw new Exception('Bouncer is not installed!');
    }

    public function authModel() : Authenticatable & FilamentUser
    {
        $modelClass = \config('filament-auth.models.user');

        return \is_a($modelClass, 'Authenticatable') ? \app($modelClass) : \app('\\App\\Models\\User');
    }
}
