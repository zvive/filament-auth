<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\UserResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;
use FilamentAuth\Events\UserCreated;

class CreateUser extends CreateRecord
{
    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.UserResource');
    }

    protected function afterCreate() : void
    {
        Event::dispatch(new UserCreated($this->record));
    }
}
