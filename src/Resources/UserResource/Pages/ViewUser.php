<?php

declare(strict_types=1);

namespace FilamentAuth\Resources\UserResource\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Actions\ButtonAction;
use Illuminate\Support\Facades\Config;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Validation\UnauthorizedException;
use FilamentAuth\Actions\ImpersonateLink;

class ViewUser extends ViewRecord
{
    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.UserResource');
    }

    protected function getActions() : array
    {
        $user = Filament::auth()->user();
        if ($user === null) {
            throw new UnauthorizedException();
        }

        if (ImpersonateLink::allowed($user, $this->record)) {
            return \array_merge([
                ButtonAction::make('impersonate')
                    ->action(function () {
                        ImpersonateLink::impersonate($this->record);
                    }),
            ], parent::getActions());
        }

        return parent::getActions();
    }
}
