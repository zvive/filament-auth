<?php

declare(strict_types=1);

namespace Phpsa\FilamentAuthentication\Widgets;

use Filament\Widgets\TableWidget;
use Illuminate\Support\Facades\Config;
use Filament\Tables\Columns\TextColumn;
use FilamentAuth\Concerns\HasFilamentAuth;
use Illuminate\Database\Eloquent\Builder;

class LatestUsersWidget extends TableWidget
{
    use HasFilamentAuth;

    protected function getTableQuery() : Builder
    {
        /** @var Authenticatable $authModel */
        $authModel = \app(\config('filament-auth.models.user')) ?? \app('\\App\\Models\\User');

        return static::authModel()
            ->query()
            ->latest()
            ->limit(Config::get('filament-auth.Widgets.LatestUsers.limit'));
    }

    protected function getTableColumns() : array
    {
        return [
            TextColumn::make('id')
                ->label('ID'),
            TextColumn::make('name')
                ->label((string) (\__('filament-auth::filament-auth.field.user.name'))),
            TextColumn::make('created_at')
                ->humanDate()
                ->label((string) (\__('filament-auth::filament-auth.field.user.created_at'))),
        ];
    }

    protected function isTablePaginationEnabled() : bool
    {
        return false;
    }

    public static function canView() : bool
    {
        return Config::get('filament-auth.Widgets.LatestUsers.enabled', true)
        && static::getResource()::canViewAny();
    }

    public static function getResource() : string
    {
        return Config::get('filament-auth.resources.UserResource');
    }

    public static function getSort() : int
    {
        return Config::get('filament-auth.Widgets.LatestUsers.sort', 0);
    }
}
