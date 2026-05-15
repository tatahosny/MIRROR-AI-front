<?php

namespace App\Filament\Resources\SkinAnalyses\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Grid;
use Filament\Forms\Components\KeyValue;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SkinAnalysisForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(3)->schema([
                    // Left Column (Image & Basic Info)
                    Grid::make(1)->schema([
                        Section::make('صورة الوجه والملخص')
                            ->schema([
                                FileUpload::make('image_path')
                                    ->image()
                                    ->directory('skin-analyses')
                                    ->disabled()
                                    ->columnSpanFull()
                                    ->hiddenLabel(),
                                
                                Select::make('detected_skin_type')
                                    ->options([
                                        'Normal' => 'Normal',
                                        'Dry' => 'Dry',
                                        'Oily' => 'Oily',
                                        'Combination' => 'Combination',
                                        'Sensitive' => 'Sensitive',
                                    ])
                                    ->disabled()
                                    ->label('نوع البشرة (Skin Type)'),

                                Toggle::make('sensitive_barrier')
                                    ->label('حاجز بشرة حساس (Sensitive Barrier)')
                                    ->disabled(),
                                
                                Textarea::make('summary')
                                    ->label('ملخص وتقييم الذكاء الاصطناعي')
                                    ->rows(4)
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),
                    ])->columnSpan(1),

                    // Right Column (AI Detailed Metrics)
                    Grid::make(1)->schema([
                        Section::make('التقييمات العامة (Global Scores 0-100)')
                            ->schema([
                                KeyValue::make('global_scores')
                                    ->label('')
                                    ->disabled()
                                    ->columnSpanFull(),
                            ]),

                        Section::make('المشاكل التفصيلية (Detailed Concerns)')
                            ->description('التقييم المفصل للحبوب، التصبغات، الاحمرار، التجاعيد والهالات')
                            ->schema([
                                KeyValue::make('detected_concerns')
                                    ->label('')
                                    ->disabled()
                                    ->columnSpanFull(),
                            ])->collapsed(),

                        Section::make('سياق المستخدم الصحي (User Context)')
                            ->schema([
                                Textarea::make('user_answers')
                                    ->label('الحالة الصحية المدخلة من المستخدم')
                                    ->disabled()
                                    ->columnSpanFull(),
                            ])->collapsed(),
                    ])->columnSpan(2),
                ])
            ]);
    }
}
