<?php

namespace App\Filament\Resources\SkinAnalyses\Pages;

use App\Filament\Resources\SkinAnalyses\SkinAnalysisResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSkinAnalyses extends ListRecords
{
    protected static string $resource = SkinAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // CreateAction::make(),
        ];
    }
}
