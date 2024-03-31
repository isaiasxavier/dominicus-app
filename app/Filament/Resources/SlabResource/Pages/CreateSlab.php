<?php

namespace App\Filament\Resources\SlabResource\Pages;

use App\Filament\Resources\SlabResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSlab extends CreateRecord
{
    protected static string $resource = SlabResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['price'] *= 100;

        return $data;
    }

}
