<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlabResource\Pages;
use App\Models\Slab;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
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
use Illuminate\Support\Number;

class SlabResource extends Resource
{
    protected static ?string $model = Slab::class;

    protected static ?string $slug = 'slabs';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';


    public static function form(Form $form): Form
    {
        return $form->schema(components: [
            Hidden::make('user_id')->default(Auth::user()->id),

            Placeholder::make('created_at')->label('Created Date')
                ->content(fn(?Slab $record): string => $record?->created_at?->diffForHumans() ?? '-')
                ->hidden(),

            Placeholder::make('updated_at')->label('Last Modified Date')
                ->content(fn(?Slab $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                ->hidden(),

            Section::make('SLAB NAME, ORDER NUMBER AND DESCRIPTION')
                ->description('Please, fill in the details below.')
                ->schema([
                    TextInput::make('name')->label('Name'),

                    TextInput::make('order_number')->label('Order Number'),

                    Textarea::make('description')
                        ->columnSpanFull(),
                ])->columnSpan(1)->columns(1),

            Section::make('SLAB GENERAL INFORMATION')
                ->description('Please, fill in the details below.')
                ->schema([
                    Select::make('type_stone')->label('Type of Stone')
                        ->options(options: array(
                            'composite' => 'Composite',
                            'granite'   => 'Granite',
                            'marble'    => 'Marble',
                            'quartz'    => 'Quartz',
                            'quartzite' => 'Quartzite',
                            'onyx'      => 'Onyx',
                            'soapstone' => 'Soapstone',
                            'porcelain' => 'Porcelain',
                            'ceramic'   => 'Ceramic',
                            'dekton'    => 'Dekton',
                            'neolith'   => 'Neolith',
                        )),

                    Radio::make('finish')->label('Afwerking')
                        ->options([
                            'geschuurd' => 'Geschuurd',
                            'gezoet'    => 'Gezoet',
                            'gepolijst' => 'Gepolijst',
                        ]),

                    TextInput::make('physical_position')->label('Location')
                        ->required(),

                    TextInput::make('brand')->label('Brand')
                        ->required(),

                    TextInput::make('supplier')->label('Supplier')
                        ->required(),

                    TextInput::make('price')->label('Price')
                        ->numeric(),
                ])->columnSpan(1)->columns(2),

            Section::make('SLAB DIMENSIONS AND QUANTITY')
                ->description('Please, fill in the details below. (The Square Meters will be calculated automatically)')
                ->schema([
                    TextInput::make('thickness')->label('Dikte (mm)')
                        ->required()
                        ->integer(),

                    TextInput::make('width')->label('Width (mm)')
                        ->required()
                        ->integer(),

                    TextInput::make('length')->label('Length (mm)')
                        ->required()
                        ->integer(),

                    TextInput::make('quantity')->label('Quantity')
                        ->required()
                        ->integer(),

                    Placeholder::make('square_meters')->label('M²')
                        ->content(fn(?Slab $record): string => $record ?
                            Number::format((($record->width / 1000) * ($record->length / 1000)) * $record->quantity, precision: 2) : '0'),
                ])->columnSpan(1)->columns(3),

        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([

            TextColumn::make('name')->searchable()->sortable()->Label('Name'),

            TextColumn::make('order_number')->label('Order Number'),

            TextColumn::make('finish')->label('Afwerking'),

            TextColumn::make('thickness')->label('Dikte (mm)'),

            TextColumn::make('quantity')->label('Quantity'),

            TextColumn::make('square_meters')->label('M²')
                ->default(fn(?Slab $record): string => $record ?
                    Number::format(
                        (($record->width / 1000) * ($record->length / 1000)) * $record->quantity,
                        precision: 2) : '0'),

            TextColumn::make('type_stone')->label('Type'),

            TextColumn::make('physical_position')->label('Location'),
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
            'index'  => Pages\ListSlab::route('/'),
            'create' => Pages\CreateSlab::route('/create'),
            'edit'   => Pages\EditSlab::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->withoutGlobalScopes([SoftDeletingScope::class,]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(
        Model $record
    ): array{
        $details = [];

        if($record->user){
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
