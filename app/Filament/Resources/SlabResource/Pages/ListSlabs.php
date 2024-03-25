<?php

namespace App\Filament\Resources\SlabsResource\Pages;

use App\Filament\Resources\SlabsResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSlabs extends ListRecords
{
    protected static string $resource = SlabsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
