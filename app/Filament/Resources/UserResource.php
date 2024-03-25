<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\FontProviders\Contracts\FontProvider;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

                /*Forms\Components\TextInput::make('roles')
                    ->label('roles')
                    ->required()
//                    ->disabled()
                    ->autocomplete('name'),*/


                /*Forms\Components\PasswordInput::make('password')
                    ->label('Password')
                    ->required()
                    ->autocomplete('new-password'),*/
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                /*Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->primary(),*/
                Tables\Columns\TextColumn::make('name')
                    ->icon('heroicon-m-user')
                    ->iconColor('primary')
                    ->label('Name'),

                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->iconColor('primary')
                    ->fontFamily('mono')
                    ->label('Email'),

                Tables\Columns\TextColumn::make('model_has_roles')

                    ->label('Roles'),



            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            /*'roles' => function ($query) {
                $query->select('roles.name')
                    ->join('model_has_roles', 'roles.id', '=', 'model_has_roles.role_id')
                    ->join('users', 'model_has_roles.model_id', '=', 'users.id')
                    ->where('model_has_roles.model_type', User::class);
            },*/
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
