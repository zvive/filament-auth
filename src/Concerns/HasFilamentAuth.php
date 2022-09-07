<?php

declare(strict_types=1);

namespace FilamentAuth\Concerns;

use Illuminate\Contracts\Auth\Authenticatable;
use FilamentAuth\FilamentAuth;
use Illuminate\Database\Eloquent\Model;

trait HasFilamentAuth
{
    public static function filamentAuth() : FilamentAuth
    {
        return \app(\FilamentAuth\FilamentAuth::class);
    }

    public static function authPackage() : string
    {
        return static::filamentAuth()->authPackage();
    }

    public static function authModel() : Authenticatable | Model
    {
        return static::filamentAuth()->authModel();
    }
}
