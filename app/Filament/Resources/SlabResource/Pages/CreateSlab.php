<?php

namespace App\Filament\Resources\SlabResource\Pages;

use App\Filament\Resources\SlabResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSlab extends CreateRecord
{
    protected static string $resource = SlabResource::class;

    public function publicMutateFormDataBeforeCreate(array $data): array
    {
        return $this->mutateFormDataBeforeCreate($data);
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['price'] *= 100;

        $data['square_meters'] = round((($data['width'] * $data['length']) / 1000000) * $data['quantity'], 2);

        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [

        ];
    }


}
