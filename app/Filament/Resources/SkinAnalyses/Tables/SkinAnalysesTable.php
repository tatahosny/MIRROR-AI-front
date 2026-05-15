<?php

namespace App\Filament\Resources\SkinAnalyses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkinAnalysesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image_path')
                    ->label('الصورة')
                    ->circular()
                    ->disk('public'),
                
                TextColumn::make('created_at')
                    ->label('تاريخ التحليل')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('detected_skin_type')
                    ->label('نوع البشرة')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Normal' => 'success',
                        'Dry' => 'warning',
                        'Oily' => 'danger',
                        'Combination' => 'primary',
                        'Sensitive' => 'gray',
                        default => 'gray',
                    })
                    ->searchable(),

                IconColumn::make('sensitive_barrier')
                    ->label('حاجز حساس')
                    ->boolean(),

                TextColumn::make('summary')
                    ->label('الملخص')
                    ->limit(50)
                    ->searchable(),

                TextColumn::make('user_id')
                    ->label('رقم المستخدم')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()->label('عرض'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
