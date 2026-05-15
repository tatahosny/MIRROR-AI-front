<?php

namespace App\Filament\Widgets;

use App\Models\SkinAnalysis;
use Filament\Widgets\ChartWidget;

class SkinTypesChart extends ChartWidget
{
    protected ?string $heading = 'توزيع أنواع البشرة';

    protected static ?int $sort = 2;

    protected ?string $pollingInterval = '60s';

    protected function getData(): array
    {
        $skinTypes = SkinAnalysis::whereNotNull('detected_skin_type')
            ->selectRaw('detected_skin_type, count(*) as count')
            ->groupBy('detected_skin_type')
            ->pluck('count', 'detected_skin_type')
            ->toArray();

        if (empty($skinTypes)) {
            return [
                'datasets' => [
                    [
                        'label' => 'عدد التحاليل',
                        'data' => [1],
                        'backgroundColor' => ['#E0E0E0'],
                    ],
                ],
                'labels' => ['لا توجد بيانات'],
            ];
        }

        $labels = array_map(function ($type) {
            return match ($type) {
                'dry' => 'جافة',
                'oily' => 'دهنية',
                'combination' => 'مختلطة',
                'normal' => 'عادية',
                'sensitive' => 'حساسة',
                default => $type,
            };
        }, array_keys($skinTypes));

        return [
            'datasets' => [
                [
                    'label' => 'عدد التحاليل',
                    'data' => array_values($skinTypes),
                    'backgroundColor' => [
                        '#FF6384',
                        '#36A2EB',
                        '#FFCE56',
                        '#4BC0C0',
                        '#9966FF',
                    ],
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'bottom',
                    'rtl' => true,
                    'labels' => [
                        'font' => [
                            'family' => 'Cairo',
                        ],
                    ],
                ],
            ],
            'maintainAspectRatio' => false,
        ];
    }
}
