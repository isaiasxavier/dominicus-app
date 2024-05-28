<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Forms\Form;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Section as InfolistSection;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;


class ActivityLogResource extends Resource
{


    protected static ?string $model = ActivityLog::class;

    protected static ?string $slug = 'activity-logs';

    protected static ?string $navigationIcon = 'heroicon-m-book-open';

    public static function canViewAny(): bool
    {
        return auth()->user() && auth()->user()->hasAnyRole(['super_admin']);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                /*Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?ActivityLog $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?ActivityLog $record): string => $record?->updated_at?->diffForHumans() ?? '-'),

                TextInput::make('log_name')
                    ->required(),

                TextInput::make('description')
                    ->required(),

                TextInput::make('subject_type')
                    ->required(),

                TextInput::make('event')
                    ->required(),

                TextInput::make('subject_id')
                    ->required()
                    ->integer(),

                TextInput::make('causer_type')
                    ->required(),

                TextInput::make('causer_id')
                    ->required()
                    ->integer(),

                TextInput::make('batch_uuid')
                    ->required(),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('log_name'),

                TextColumn::make('description'),

                TextColumn::make('subject_type'),

                TextColumn::make('event'),

                TextColumn::make('subject_id'),

                TextColumn::make('causer_type'),

                TextColumn::make('causer_id'),

                /*TextColumn::make('properties')
                    ->formatStateUsing(function ($record) {
                        return is_array($record->properties) ? http_build_query($record->properties, '', ', ') : $record->properties;
                    }),*/

                /*TextColumn::make('batch_uuid'),*/
            ])
            ->filters([
                //
            ])
            ->actions([
                /*EditAction::make(),
                DeleteAction::make(),*/
                Action::make('View')
                    ->label('Full Log')
                    ->icon('heroicon-m-book-open')
                    ->infolist([
                        Split::make([
                            InfolistSection::make('ACTIVITY LOG INFO')
                                ->schema([
                                    TextEntry::make('log_name')->label('Log Name')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('description')->label('Description')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('subject_type')->label('Subject Type')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('event')->label('Event')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('subject_id')->label('Subject ID')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('causer_type')->label('Causer Type')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                    TextEntry::make('causer_id')->label('User ID')
                                        ->weight(FontWeight::Bold)
                                        ->color('info'),
                                ])->columns(3),
                            InfolistSection::make('REGISTERED/UPDATED')
                                ->schema([
                                    TextEntry::make('created_at')->label('Registered Date')
                                        ->dateTime()
                                        ->weight(FontWeight::Bold)
                                        ->color('warning'),
                                    TextEntry::make('updated_at')->label('Updated Date')
                                        ->dateTime()
                                        ->weight(FontWeight::Bold)
                                        ->color('warning'),
                                ])->columns(),
                        ])->from('md'),
                        Split::make([
                            Fieldset::make('OLD DATA')
                                ->schema([
                                    KeyValueEntry::make('properties.old')
                                        ->keyLabel('Property Name')
                                        ->valueLabel('Property Value'),
                                ])->columns(1),
                        ])->from('md'),
                        Split::make([
                            Fieldset::make('DATA MODIFIED')
                                ->schema([
                                    KeyValueEntry::make('properties.attributes')
                                        ->keyLabel('Property Name')
                                        ->valueLabel('Property Value'),
                                ])->columns(1),
                        ])->from('md'),

                    ]),

            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            /*'create' => Pages\CreateActivityLog::route('/create'),*/
            /*'edit'   => Pages\EditActivityLog::route('/{record}/edit'),*/
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return [];
    }
}
