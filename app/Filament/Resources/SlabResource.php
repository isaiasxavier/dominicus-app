<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SlabResource\Pages;
use App\Models\Slab;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
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
    protected static ?string $model = Slab::class;

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
                    ->content(fn(?Slab $record): string => $record?->created_at?->diffForHumans() ?? '-')
                    ->hidden(),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?Slab $record): string => $record?->updated_at?->diffForHumans() ?? '-')
                    ->hidden(),

                TextInput::make('name')
                    ->required(),

                TextInput::make('physical_position')
                    ->required(),

                Select::make('type_stone')
                    ->options([
                        'composite' => 'Composite',
                        'granite' => 'Granite',
                        'marble' => 'Marble',
                        'quartz' => 'Quartz',
                        'quartzite' => 'Quartzite',
                        'onyx' => 'Onyx',
                        'soapstone' => 'Soapstone',
                        'porcelain' => 'Porcelain',
                        'ceramic' => 'Ceramic',
                        'dekton' => 'Dekton',
                        'neolith' => 'Neolith',
                    ])
                    ->label('Type of Stone'),

                Radio::make('finish')
                    ->options([
                        'geschuurd' => 'geschuurd',
                        'gezoet' => 'gezoet',
                        'gepolijst' => 'gepolijst',
                    ])
                    ->label('Afwerking'),

                TextInput::make('width')
                    ->required()
                    ->integer()
                    ->label('Width (mm)'),

                TextInput::make('length')
                    ->required()
                    ->integer()
                    ->label('Length (mm)'),

                TextInput::make('quantity')
                    ->required()
                    ->integer(),

                Placeholder::make('square_meters')
                    // Calcula a área em metros quadrados e multiplica pela quantidade
                    ->content(fn(?Slab $record): string => number_format((($record->width * $record->length) / 1000000) * $record->quantity, 2))
                    ->label('M²'),

                TextInput::make('brand')
                    ->required(),

                TextInput::make('description')
                    ->required(),



                TextInput::make('supplier')
                    ->required(),

                TextInput::make('order_number'),

                TextInput::make('price')
                    ->numeric(),

                /*Foi alterado para finish
                 *
                  TextInput::make('polishment')
                    ->required(),*/


                TextInput::make('thickness')
                    ->required()
                    ->integer()
                    ->label('Dikte (mm)'),





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

                /**
                 * Cria uma coluna de texto para o campo 'price'.
                 *
                 * - `sortable()`: torna a coluna ordenável.
                 * - `money('eur')`: formata o valor da coluna como uma quantia em dinheiro na moeda Euro (EUR).
                 * - `getStateUsing()`: personaliza o valor que é exibido na coluna. Neste caso,
                 *     o preço é armazenado em centavos na base de dados, então dividimos por 100 para converter
                 *     para a unidade de moeda correta.
                 *
                 * @param Slab $record Uma instância do modelo Slab, que representa a linha atual na tabela.
                 * @return float O preço do registro, convertido de centavos para euros.
                 */
                /*TextColumn::make('price')
                    ->sortable()
                    ->money('EUR')
                    ->getStateUsing(function (Slab $record): float {
                        return $record->price / 100;
                    }),*/

//                TextColumn::make('description'),


//                TextColumn::make('supplier'),

                /**
                 * TextColumn::make('user.name')
                 * Este código cria uma coluna de texto para a tabela na interface do usuário.
                 *
                 * TextColumn::make('user.name'): Esta linha cria uma nova coluna de texto para a tabela.
                 * O argumento 'user.name' é o nome do campo no modelo de dados que esta coluna deve exibir.
                 * Neste caso, está exibindo o nome do usuário associado ao registro atual.

                 */
                /*TextColumn::make('user.name')
                    ->label('Employee'),*/

                TextColumn::make('order_number'),

//                TextColumn::make('price'),

//                TextColumn::make('polishment'),                  //Foi alterado para finish
                TextColumn::make('finish')
                    ->label('Afwerking'),

                TextColumn::make('thickness')
                    ->label('Dikte (mm)'),

                /*TextColumn::make('width'),

                TextColumn::make('length'),*/

                TextColumn::make('quantity'),

                TextColumn::make('square_meters')
                    // Calcula a área em metros quadrados e multiplica pela quantidade
//                    ->default(fn(?Slab $record): string => number_format((($record->width * $record->length) / 1000000) * $record->quantity, 2))
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
