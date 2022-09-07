<?php

declare(strict_types=1);

namespace FilamentAuth\Resources;

use App\Models\User;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\MultiSelect;
use Illuminate\Support\Facades\Hash;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TagsColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\TernaryFilter;
use FilamentAuth\Actions\ImpersonateLink;
use FilamentAuth\Resources\UserResource\Pages\EditUser;
use FilamentAuth\Resources\UserResource\Pages\ViewUser;
use FilamentAuth\Resources\UserResource\Pages\ListUsers;
use FilamentAuth\Resources\UserResource\Pages\CreateUser;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserResource extends Resource
{
    // protected static ?string $model                = User::class;
    protected static ?string $navigationIcon       = 'heroicon-o-user';
    protected static ?string $recordTitleAttribute = 'name';

    public function __construct()
    {
        // static::$model = \config('filament-auth.models.User');
    }

    public static function getModel() : string
    {
        return \config('filament-auth.models.User');
    }

    protected static function getNavigationGroup() : ?string
    {
        return (string) (\__('filament-auth::filament-auth.section.group'));
    }

    public static function getLabel() : string
    {
        return (string) (\__('filament-auth::filament-auth.section.user'));
    }

    public static function getPluralLabel() : string
    {
        return (string) (\__('filament-auth::filament-auth.section.users'));
    }

    public static function form(Form $form) : Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('name')
                            ->label((string) (\__('filament-auth::filament-auth.field.user.name')))
                            ->required(),
                        TextInput::make('email')
                            ->required()
                            ->email()
                            ->unique(table: \config('filament-auth.models.user'), ignorable: fn (?Authenticatable $record) : ?Authenticatable => $record)
                            ->label((string) (\__('filament-auth::filament-auth.field.user.email'))),
                        TextInput::make('password')
                            ->same('passwordConfirmation')
                            ->password()
                            ->maxLength(255)
                            ->required(fn ($component, $get, $livewire, $model, $record, $set, $state) => $record === null)
                            ->dehydrateStateUsing(fn ($state) => !empty($state) ? Hash::make($state) : '')
                            ->label((string) (\__('filament-auth::filament-auth.field.user.password'))),
                        TextInput::make('passwordConfirmation')
                            ->password()
                            ->dehydrated(false)
                            ->maxLength(255)
                            ->label((string) (\__('filament-auth::filament-auth.field.user.confirm_password'))),
                        MultiSelect::make('roles')
                            ->relationship('roles', 'name')
                            ->preload(\config('filament-auth.preload_roles'))
                            ->label((string) (\__('filament-auth::filament-auth.field.user.roles'))),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table) : Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label((string) (\__('filament-auth::filament-auth.field.id'))),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()->label((string) (\__('filament-auth::filament-auth.field.user.name'))),
                TextColumn::make('email')
                    ->searchable()
                    ->sortable()->label((string) (\__('filament-auth::filament-auth.field.user.email'))),
                IconColumn::make('email_verified_at')
                    ->options([
                        'heroicon-o-check-circle',
                        'heroicon-o-x-circle' => fn ($state) : bool => $state === null,
                    ])
                    ->colors([
                        'success',
                        'danger' => fn ($state) : bool => $state === null,
                    ])
                    ->label((string) (\__('filament-auth::filament-auth.field.user.verified_at'))),
                // IconColumn::make('roles')
                //     ->tooltip(
                //         fn (User $record): string => $record->getRoleNames()->implode(",\n")
                //     )->options(
                //         [
                //             'heroicon-o-shield-check'
                //         ]
                //     )->colors(['success']),
                TagsColumn::make('roles.name')
                    ->label((string) (\__('filament-auth::filament-auth.field.user.roles'))),
                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i:s')
                    ->label((string) (\__('filament-auth::filament-auth.field.user.created_at'))),
            ])
            ->filters([
                TernaryFilter::make('email_verified_at')
                    ->label((string) (\__('filament-auth::filament-auth.filter.verified')))
                    ->nullable(),

            ])
            ->prependActions([
                ImpersonateLink::make(),
            ]);
    }

    public static function getRelations() : array
    {
        return [
            //
        ];
    }

    public static function getPages() : array
    {
        return [
            'index'  => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit'   => EditUser::route('/{record}/edit'),
            'view'   => ViewUser::route('/{record}'),
        ];
    }
}
