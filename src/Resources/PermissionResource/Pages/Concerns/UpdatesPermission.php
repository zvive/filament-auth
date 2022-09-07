<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\PermissionResource\Pages\Concerns;

use FilamentAuth\FilamentAuth;

trait UpdatesPermission
{
    public function afterSave() : void
    {
        if (\is_a($this->record, FilamentAuth::SPATIE_PERMISSION_CONTRACT)) {
            if (\class_exists(FilamentAuth::SPATIE_PERMISSION_REGISTRAR)) {
                \app(FilamentAuth::SPATIE_PERMISSION_REGISTRAR)->forgetCachedPermissions();
            }
        }
        if (\is_a($this->record, FilamentAuth::BOUNCER_PERMISSION_MODEL)) {
            if (\class_exists(FilamentAuth::BOUNCER_MAIN_CLASS)) {
                \app(FilamentAuth::BOUNCER_MAIN_CLASS)->refresh();
            }
        }
    }
}
