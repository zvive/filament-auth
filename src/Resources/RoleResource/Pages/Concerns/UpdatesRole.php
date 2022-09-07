<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\RoleResource\Pages\Concerns;

use FilamentAuth\FilamentAuth;

trait UpdatesRole
{
    public function afterSave() : void
    {
        if (\is_a($this->record, FilamentAuth::SPATIE_ROLE_CONTRACT)) {
            if (\class_exists(FilamentAuth::SPATIE_PERMISSION_REGISTRAR)) {
                \app(FilamentAuth::SPATIE_PERMISSION_REGISTRAR)->forgetCachedPermissions();
            }
        }
        if (\is_a($this->record, FilamentAuth::BOUNCER_ROLE_MODEL)) {
            if (\class_exists(FilamentAuth::BOUNCER_MAIN_CLASS)) {
                \app(FilamentAuth::BOUNCER_MAIN_CLASS)->refresh();
            }
        }
    }
}
