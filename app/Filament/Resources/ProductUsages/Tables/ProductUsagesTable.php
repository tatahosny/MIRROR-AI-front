<?php

namespace App\Filament\Resources\ProductUsages\Tables;

use Filament\Tables;
use Filament\Tables\Table;

class ProductUsagesTable
{
    public static function make(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('product.name')
                    ->label('المنتج')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('suitable_for_skin_types')
                    ->label('أنواع البشرة')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('suitable_for_concerns')
                    ->label('المشاكل')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('usage_frequency')
                    ->label('عدد مرات الاستخدام'),

                Tables\Columns\TextColumn::make('usage_time')
                    ->label('الوقت')
                    ->badge(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_essential')
                    ->label('أساسي')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('تاريخ الإضافة')
                    ->dateTime('Y-m-d'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make(),
            ]);
    }
}
