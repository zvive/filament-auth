<?php

declare(strict_types=1);

namespace FilamentAuth;

use Filament\Facades\Filament;
use Filament\PluginServiceProvider;
use Filament\Navigation\UserMenuItem;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use FilamentAuth\Http\Middleware\ImpersonatingMiddleware;
use FilamentAuth\Widgets\LatestUsersWidget;

class FilamentAuthProvider extends PluginServiceProvider
{
    public static string $name = 'filament-auth';
    protected array $widgets   = [
        LatestUsersWidget::class,
    ];

    protected function getResources() : array
    {
        return \config('filament-auth.resources');
    }

    public function configurePackage(Package $package) : void
    {
        Config::push('filament.middleware.base', ImpersonatingMiddleware::class);

        $package->name('filament-auth')
            ->hasConfigFile()
            ->hasViews()
            ->hasRoute('web')
            ->hasTranslations();
    }

    public function getPages() : array
    {
        return \config('filament-auth.pages');
    }

    protected function registerMacros() : void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                'account' => UserMenuItem::make()->url(\route('filament.pages.profile')),
            ]);
        });

        TextColumn::macro('humanDate', function () {
            /** @var \Filament\Tables\Columns\Concerns\CanFormatState&\Filament\Tables\Columns\TextColumn $this */
            $this->formatStateUsing(fn ($state) : ?string => $state ? $state->diffForHumans() : null);

            return $this;
        });
    }
}
