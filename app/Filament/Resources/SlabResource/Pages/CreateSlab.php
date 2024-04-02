<?php

namespace App\Filament\Resources\SlabResource\Pages;

use App\Filament\Resources\SlabResource;
use App\Models\Slab;
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

        // Calcula a área em metros quadrados e multiplica pela quantidade
        $data['square_meters'] = ($data['width'] * $data['length'] / 1000000) * $data['quantity'];

        // Calcula a área em milímetros quadrados e multiplica pela quantidade
//        $data['square_meters'] = ($data['width'] * $data['length']) * $data['quantity'];

        return $data;
    }

    public function publicMutateFormDataBeforeCreate(array $data): array
    {
        return $this->mutateFormDataBeforeCreate($data);
    }


}
