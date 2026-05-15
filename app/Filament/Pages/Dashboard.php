<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\LatestAnalyses;
use App\Filament\Widgets\SkinTypesChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\TopProductsChart;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string|\BackedEnum|null $navigationIcon = null;

    protected static ?string $title = 'لوحة التحكم';

    protected static ?string $navigationLabel = 'لوحة التحكم';

    protected static ?int $navigationSort = 1;

    public function getWidgets(): array
    {
        return [
            StatsOverview::class,
            SkinTypesChart::class,
            TopProductsChart::class,
        ];
    }

    public function getColumns(): array | int
    {
        return [
            'md' => 2,
            'xl' => 3,
        ];
    }
}
