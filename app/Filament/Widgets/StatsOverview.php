<?php

namespace App\Filament\Widgets;

use App\Models\Product;
use App\Models\Category;
use App\Models\SkinAnalysis;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalAnalyses = SkinAnalysis::count();
        $todayAnalyses = SkinAnalysis::whereDate('created_at', today())->count();

        $totalProducts = Product::count();
        $activeProducts = Product::where('is_active', true)->count();

        $totalCategories = Category::count();

        // إضافة نسب التغيير
        $yesterdayAnalyses = SkinAnalysis::whereDate('created_at', today()->subDay())->count();
        $analysesChange = $yesterdayAnalyses > 0
            ? round((($todayAnalyses - $yesterdayAnalyses) / $yesterdayAnalyses) * 100, 1)
            : 100;

        return [
            Stat::make('إجمالي التحاليل', $totalAnalyses)
                ->description($todayAnalyses > 0
                    ? "{$todayAnalyses} تحليل اليوم (" . ($analysesChange > 0 ? '+' : '') . "{$analysesChange}%)"
                    : "لا توجد تحاليل اليوم")
                ->descriptionIcon($todayAnalyses > 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-clock')
                ->chart($this->getLastWeekAnalyses())
                ->color($todayAnalyses > 0 ? 'success' : 'gray'),

            Stat::make('المنتجات', $totalProducts)
                ->description("منها {$activeProducts} منتج نشط")
                ->descriptionIcon('heroicon-m-cube')
                ->color('info'),

            Stat::make('التصنيفات', $totalCategories)
                ->description('إجمالي التصنيفات')
                ->descriptionIcon('heroicon-m-tag')
                ->color('warning'),

            Stat::make('نسبة التحاليل اليوم', $todayAnalyses > 0
                ? round(($todayAnalyses / max($totalAnalyses, 1)) * 100, 1) . '%'
                : '0%')
                ->description('من إجمالي التحاليل')
                ->descriptionIcon('heroicon-m-chart-pie')
                ->color('primary'),
        ];
    }

    private function getLastWeekAnalyses(): array
    {
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $count = SkinAnalysis::whereDate('created_at', $date)->count();
            $data[] = $count;
        }
        return $data;
    }
}
