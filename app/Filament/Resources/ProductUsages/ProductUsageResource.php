<?php

namespace App\Filament\Resources\ProductUsages;

use App\Filament\Resources\ProductUsages\Pages;
use App\Filament\Resources\ProductUsages\Schemas\ProductUsageForm;
use App\Filament\Resources\ProductUsages\Tables\ProductUsagesTable;
use App\Models\ProductUsage;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use UnitEnum;
use BackedEnum;

class ProductUsageResource extends Resource
{
    protected static ?string $model = ProductUsage::class;

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string | UnitEnum | null $navigationGroup = 'إدارة المنتجات';

    protected static ?string $navigationLabel = 'طرق الاستخدام';

    protected static ?string $pluralLabel = 'طرق الاستخدام';

    protected static ?string $modelLabel = 'طريقة استخدام';

    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return ProductUsageForm::make($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductUsagesTable::make($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductUsages::route('/'),
            'create' => Pages\CreateProductUsage::route('/create'),
            'edit' => Pages\EditProductUsage::route('/{record}/edit'),
        ];
    }
}
