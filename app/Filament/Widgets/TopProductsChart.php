<?php

namespace App\Filament\Widgets;

use App\Models\Recommendation;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TopProductsChart extends ChartWidget
{
    protected ?string $heading = 'أكثر المنتجات الموصى بها';

    protected static ?int $sort = 3;

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $topProducts = Recommendation::select('product_id', DB::raw('count(*) as total'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        if ($topProducts->isEmpty()) {
            return [
                'datasets' => [
                    [
                        'label' => 'عدد مرات التوصية',
                        'data' => [0],
                        'backgroundColor' => '#E0E0E0',
                    ],
                ],
                'labels' => ['لا توجد توصيات بعد'],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد مرات التوصية',
                    'data' => $topProducts->pluck('total')->toArray(),
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $topProducts
                ->map(fn ($item) => $item->product?->name ?? 'منتج محذوف')
                ->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => false,
                ],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => [
                        'stepSize' => 1,
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
