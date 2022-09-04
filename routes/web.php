<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use FilamentAuth\Actions\ImpersonateLink;

Route::get('/impersonate/stop', fn () => ImpersonateLink::leave())
    ->name('filament-auth.stop.impersonation')
    ->middleware(config('filament-auth.impersonate.guard'));
