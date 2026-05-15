<?php

namespace App\Filament\Resources\SkinAnalyses\Infolists;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SkinAnalysisInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('صورة الوجه والملخص')
                    ->schema([
                        ImageEntry::make('image_path')
                            ->hiddenLabel()
                            ->disk('public')
                            ->width('100%')
                            ->height('300px')
                            ->columnSpanFull(),
                        
                        TextEntry::make('detected_skin_type')
                            ->label('نوع البشرة (Skin Type)')
                            ->badge()
                            ->color(fn (?string $state): string => match ($state) {
                                'Normal' => 'success',
                                'Dry' => 'warning',
                                'Oily' => 'danger',
                                'Combination' => 'primary',
                                'Sensitive' => 'gray',
                                default => 'gray',
                            }),

                        IconEntry::make('sensitive_barrier')
                            ->label('حاجز بشرة حساس (Sensitive Barrier)')
                            ->boolean(),
                        
                        TextEntry::make('summary')
                            ->label('توصية الذكاء الاصطناعي')
                            ->columnSpanFull(),
                    ]),

                                Section::make('التقييمات العامة (Global Scores: 0-100)')
                    ->schema([
                        KeyValueEntry::make('global_scores')
                            ->label('')
                            ->columnSpanFull(),
                    ]),

                Section::make('المشاكل التفصيلية (Detailed Concerns)')
                    ->description('التقييم المفصل لحب الشباب، التصبغات، الاحمرار، التجاعيد والهالات')
                    ->schema([
                        Grid::make(2)->schema([
                            Section::make('Breakouts (الحبوب)')
                                ->schema([
                                    TextEntry::make('detected_concerns.breakouts.clinical_description')->label('الوصف'),
                                    TextEntry::make('detected_concerns.breakouts.severity')
                                        ->label('الشدة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%'),
                                ])->columnSpan(1)->compact(),

                            Section::make('Pigmentation (التصبغات)')
                                ->schema([
                                    TextEntry::make('detected_concerns.pigmentation.clinical_description')->label('الوصف'),
                                    TextEntry::make('detected_concerns.pigmentation.severity')
                                        ->label('الشدة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%'),
                                ])->columnSpan(1)->compact(),

                            Section::make('Redness (الاحمرار)')
                                ->schema([
                                    TextEntry::make('detected_concerns.redness.clinical_description')->label('الوصف'),
                                    TextEntry::make('detected_concerns.redness.severity')
                                        ->label('الشدة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%'),
                                ])->columnSpan(1)->compact(),

                            Section::make('Aging (التجاعيد)')
                                ->schema([
                                    TextEntry::make('detected_concerns.aging.clinical_description')->label('الوصف'),
                                    TextEntry::make('detected_concerns.aging.severity')
                                        ->label('الشدة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%'),
                                ])->columnSpan(1)->compact(),

                            Section::make('Under Eye (الهالات)')
                                ->schema([
                                    TextEntry::make('detected_concerns.under_eye.clinical_description')->label('الوصف'),
                                    TextEntry::make('detected_concerns.under_eye.severity')
                                        ->label('الشدة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%'),
                                ])->columnSpan(1)->compact(),
                        ]),
                    ])->collapsed(),

                Section::make('سياق المستخدم الصحي (User Context)')
                    ->schema([
                        TextEntry::make('user_answers')
                            ->label('حالة المستخدم')
                            ->placeholder('لا توجد بيانات مسجلة')
                            ->columnSpanFull(),
                    ])->collapsed(),

                Section::make('المنتجات المرشحة والروتين المقترح (Recommended Routine)')
                    ->schema([
                        RepeatableEntry::make('recommendations')
                            ->hiddenLabel()
                            ->schema([
                                Grid::make(4)->schema([
                                    ImageEntry::make('product.image_url')
                                        ->label('صورة المنتج')
                                        ->circular(),
                                    
                                    TextEntry::make('product.name')
                                        ->label('المنتج')
                                        ->weight('bold'),

                                    TextEntry::make('match_score')
                                        ->label('نسبة المطابقة')
                                        ->formatStateUsing(fn ($state) => number_format($state * 100, 0) . '%')
                                        ->badge()
                                        ->color('success'),

                                    TextEntry::make('usage.usage_time')
                                        ->label('وقت الاستخدام')
                                        ->badge(),

                                    TextEntry::make('usage.how_to_use')
                                        ->label('طريقة الاستخدام')
                                        ->columnSpan(2),

                                    TextEntry::make('usage.usage_frequency')
                                        ->label('التكرار'),
                                ]),
                            ])
                            ->columnSpanFull(),
                    ])->collapsible()->columnSpanFull(),
            ]);
    }
}
