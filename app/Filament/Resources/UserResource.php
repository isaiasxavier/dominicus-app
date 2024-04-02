<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\FontProviders\Contracts\FontProvider;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-m-user';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->autocomplete('name'),

                Forms\Components\TextInput::make('email')
                    ->label('Email')
                    ->required()
                    ->autocomplete('email'),


                Forms\Components\Select::make('role_id')
                    ->label('Roles')
                    ->required()
                    ->options(
                        Role::query()->pluck('name', 'id')->toArray()
                    ),

                Forms\Components\TextInput::make('password')
                    ->label('Password')
                    ->required()
                    ->autocomplete('new-password'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns(components: [

                /*Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->primary(),*/
                Tables\Columns\TextColumn::make('name')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->sortable()
                    ->searchable()
                    ->label('Name'),

                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary')
                    ->fontFamily('mono')
                    ->sortable()
                    ->searchable()
                    ->label('Email'),

                /**
                 * Cria uma coluna na tabela para exibir os papéis (roles) do usuário.
                 * @method label 'Roles' Define o rótulo da coluna.
                 * @method make  'roles' Cria uma nova coluna de texto com o nome 'roles'.
                 * @method name  'roles.name' Define o nome da coluna que será usada para buscar os dados.
                 * Neste caso, 'roles.name' indica que estamos buscando o nome do papel (role) na relação 'roles'.
                 */
                Tables\Columns\TextColumn::make('roles')
                    ->name('roles.name')
                    ->sortable()
                    ->searchable()
                    ->badge(/*Role::query()->where('name', true)->count()*/)
                    ->label('Access Level')


            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {

        return [



        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
