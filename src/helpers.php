<?php

declare(strict_types=1);

if (!function_exists('fa_get_bouncer_model')) {
    function fa_get_bouncer_model($model): string
    {
        if (!in_array($model, ['role', 'ability'], true)) {
            throw new \Exception('Model type must be role or ability');
        }
        $modelClass = $model === 'role'
            ? \Silber\Bouncer\Database\Role::class
            : \Silber\Bouncer\Database\Ability::class;
        if (class_exists("\Silber\Bouncer\Database\Models")) {
            return app('Silber\Bouncer\Database\Models')::classname($modelClass);
        }
    }
}

if (!function_exists('fa_get_spatie_permission_model')) {
    function fa_get_spatie_permission_model($model) : string
    {
        if (!in_array($model, ['role', 'permission'], true)) {
            throw new \Exception('Model type must be role or permission');
        }
        $modelClass = $model === 'role'
            ? \Spatie\Permission\Models\Role::class
            : \Spatie\Permission\Models\Permission::class;
        return config("permission.models.{$model}", $modelClass);
    }
}

if (!function_exists('fa_get_auth_model')) {
    function fa_get_auth_model($modelType):string
    {
        $package_name = config('filament-auth.permission_package');
        if (!in_array($package_name, ['laravel-permission', 'bouncer'], true)) {
            throw new \Exception("Package name must be 'laravel-permission' or 'bouncer'");
        }
        if ($package_name === 'bouncer') {
            $modelType = $modelType === 'permission' ? 'ability' : $modelType;
            $model     = fa_get_bouncer_model($modelType);
        }

        if ($package_name === 'laravel-permission') {
            $model = fa_get_spatie_permission_model($modelType);
        }

        if (!is_string($model) || !class_exists($model)) {
            $package_command = $package_name === 'bouncer' ? 'composer require silber/bouncer' : 'composer require spatie/laravel-permission';
            throw new \Exception("It appears the permission package is not installed. Please run: {$package_command} and try again.");
        }

        return $model;
    }
}
