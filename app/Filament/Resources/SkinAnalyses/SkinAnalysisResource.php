<?php

namespace App\Filament\Resources\SkinAnalyses;

use App\Filament\Resources\SkinAnalyses\Pages\CreateSkinAnalysis;
use App\Filament\Resources\SkinAnalyses\Pages\EditSkinAnalysis;
use App\Filament\Resources\SkinAnalyses\Pages\ListSkinAnalyses;
use App\Filament\Resources\SkinAnalyses\Tables\SkinAnalysesTable;
use App\Filament\Resources\SkinAnalyses\Infolists\SkinAnalysisInfolist;
use App\Models\SkinAnalysis;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SkinAnalysisResource extends Resource
{
    protected static ?string $model = SkinAnalysis::class;

    protected static ?string $modelLabel = 'تحليل بشرة';

    protected static ?string $pluralModelLabel = 'تحاليل البشرة';

    protected static ?string $navigationLabel = 'تحاليل البشرة';

    protected static ?string $breadcrumb = 'تحاليل البشرة';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return SkinAnalysesTable::configure($table);
    }

    public static function infolist(Schema $schema): Schema
    {
        return SkinAnalysisInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSkinAnalyses::route('/'),
        ];
    }
}
