<?php

declare(strict_types=1);

return [
    'models' => [
        'User' => \App\Models\User::class,
    ],
    'permission_package' => 'bouncer',
    'resources'          => [
        'UserResource'       => \FilamentAuth\Resources\UserResource::class,
        'RoleResource'       => \FilamentAuth\Resources\RoleResource::class,
        'PermissionResource' => \FilamentAuth\Resources\PermissionResource::class,
    ],
    'pages' => [
        'Profile' => \FilamentAuth\Pages\Profile::class,
    ],
    'Widgets' => [
        'LatestUsers' => [
            'enabled' => true,
            'limit'   => 5,
            'sort'    => 0,
        ],
    ],
    'preload_roles' => true,
    'impersonate'   => [
        'enabled'  => true,
        'guard'    => 'web',
        'redirect' => '/',
    ],
];
