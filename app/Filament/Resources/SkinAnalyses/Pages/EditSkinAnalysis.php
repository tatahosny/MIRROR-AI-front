<?php

namespace App\Filament\Resources\SkinAnalyses\Pages;

use App\Filament\Resources\SkinAnalyses\SkinAnalysisResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditSkinAnalysis extends EditRecord
{
    protected static string $resource = SkinAnalysisResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
