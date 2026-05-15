<?php

namespace App\Filament\Resources\ProductUsages\Pages;

use App\Filament\Resources\ProductUsages\ProductUsageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditProductUsage extends EditRecord
{
    protected static string $resource = ProductUsageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
