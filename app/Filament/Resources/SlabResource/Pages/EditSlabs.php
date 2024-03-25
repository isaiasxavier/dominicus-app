<?php

namespace App\Filament\Resources\SlabsResource\Pages;

use App\Filament\Resources\SlabsResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditSlabs extends EditRecord
{
    protected static string $resource = SlabsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
