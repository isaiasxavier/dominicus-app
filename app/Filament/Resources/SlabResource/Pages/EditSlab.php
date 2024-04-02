<?php

namespace App\Filament\Resources\SlabResource\Pages;

use App\Filament\Resources\SlabResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSlab extends EditRecord
{
    protected static string $resource = SlabResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }


    protected function mutateFormDataBeforeFill(array $data): array
    {
        $data['price'] /= 100;

        $data['square_meters'] = ($data['width'] * $data['length'] / 1000000) * $data['quantity'];

        return $data;
    }


    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['price'] *= 100;

        // Calcula a área em milímetros quadrados e multiplica pela quantidade
        $data['square_meters'] = ($data['width'] * $data['length']) * $data['quantity'];

        return $data;
    }

}
