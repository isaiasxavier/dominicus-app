<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlabResource\Pages;
use App\Models\Slabs;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class SlabResource extends Resource
{
    protected static ?string $model = Slabs::class;

    protected static ?string $slug = 'slabs';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';



    public static function form(Form $form): Form
    {
        return $form
            ->schema([

                /*Cria um text field onde eu seleciono os id da tabelas users */
                Hidden::make('user_id')
                    ->default(Auth::user()->id),


                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?Slabs $record): string => $record?->created_at?->diffForHumans() ?? '-')
                    ->hidden(),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Slabs $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                    ->hidden(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('brand')
                    ->required(),

                TextInput::make('description')
                    ->required(),

                TextInput::make('quantity')
                    ->required()
                    ->integer(),

                TextInput::make('supplier')
                    ->required(),

                TextInput::make('order_number'),

                TextInput::make('price')
                    ->numeric(),

                TextInput::make('polishment')
                    ->required(),

                TextInput::make('thickness')
                    ->required()
                    ->integer(),

                TextInput::make('width')
                    ->required()
                    ->numeric(),

                TextInput::make('length')
                    ->required()
                    ->numeric(),

                TextInput::make('square_meters')
                    ->required()
                    ->numeric(),

                TextInput::make('physical_position')
                    ->required(),

                TextInput::make('type_stone')
                    ->required(),
            ]);
    }

    /**
     * @throws \Exception
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

//                TextColumn::make('brand'),

                    TextColumn::make('price')
                            ->sortable()
                            ->money('eur')
                            ->getStateUsing(function (Slabs $record): float {
                                return $record->price / 100;
                            }),

//                TextColumn::make('description'),

                TextColumn::make('quantity'),

                TextColumn::make('supplier'),

                TextColumn::make('order_number'),

//                TextColumn::make('price'),

                TextColumn::make('polishment'),

                TextColumn::make('thickness'),

                /*TextColumn::make('width'),

                TextColumn::make('length'),*/

                TextColumn::make('square_meters')
                    ->label('M²'),

                TextColumn::make('type_stone')
                    ->label('Type'),

                TextColumn::make('physical_position')
                    ->label('Location'),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSlab::route('/'),
            'create' => Pages\CreateSlab::route('/create'),
            'edit' => Pages\EditSlab::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
