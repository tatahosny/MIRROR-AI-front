<?php

namespace App\Filament\Resources\ProductUsages\Pages;

use App\Filament\Resources\ProductUsages\ProductUsageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListProductUsages extends ListRecords
{
    protected static string $resource = ProductUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
