<?php

namespace App\Filament\Resources\Products\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

use Filament\Tables;
use Filament\Tables\Table;

class UsageRelationManager extends RelationManager
{
    protected static string $relationship = 'usage';

    protected static ?string $title = 'طريقة الاستخدام';

    protected static ?string $recordTitleAttribute = 'product_id';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات الاستخدام')
                    ->schema([
                        TagsInput::make('suitable_for_skin_types')
                            ->label('مناسب لأنواع البشرة')
                            ->placeholder('أضف نوع بشرة')
                            ->splitKeys(['tab', 'enter'])
                            ->helperText('مثال: دهنية, جافة, مختلطة'),

                       TagsInput::make('suitable_for_concerns')
                            ->label('مناسب للمشاكل')
                            ->placeholder('أضف مشكلة')
                            ->splitKeys(['tab', 'enter'])
                            ->helperText('مثال: حب شباب, تجاعيد, تصبغات')
                            ->dehydrateStateUsing(fn ($state) => is_array($state) ? implode(',', $state) : $state)
                            ->afterStateHydrated(fn ($component, $state) => $component->state($state ? explode(',', $state) : [])),

                        TextInput::make('usage_frequency')
                            ->label('عدد مرات الاستخدام')
                            ->placeholder('مرتين يومياً'),

                        Select::make('usage_time')
                            ->label('وقت الاستخدام')
                            ->options([
                                'صباحاً' => 'صباحاً',
                                'مساءً' => 'مساءً',
                                'صباحاً ومساءً' => 'صباحاً ومساءً',
                            ]),

                        Textarea::make('how_to_use')
                            ->label('كيفية الاستخدام')
                            ->rows(3)
                            ->columnSpanFull(),

                        TextInput::make('amount_to_use')
                            ->label('الكمية المستخدمة')
                            ->placeholder('حبة بازلاء'),

                        Textarea::make('warnings')
                            ->label('تحذيرات')
                            ->rows(2)
                            ->columnSpanFull(),

                        TextInput::make('priority')
                            ->label('الأولوية')
                            ->numeric()
                            ->default(5)
                            ->minValue(1)
                            ->maxValue(10),

                        Toggle::make('is_essential')
                            ->label('منتج أساسي')
                            ->default(true),
                    ])
                    ->columns(2),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('suitable_for_skin_types')
                    ->label('أنواع البشرة')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('suitable_for_concerns')
                    ->label('المشاكل')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('usage_frequency')
                    ->label('الاستخدام')
                    ->searchable(),

                Tables\Columns\TextColumn::make('usage_time')
                    ->label('الوقت')
                    ->badge(),

                Tables\Columns\TextColumn::make('priority')
                    ->label('الأولوية')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_essential')
                    ->label('أساسي')
                    ->boolean(),
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->label('إضافة طريقة استخدام'),
            ])
            ->actions([
                \Filament\Actions\EditAction::make()
                    ->label('تعديل'),

                \Filament\Actions\DeleteAction::make()
                    ->label('حذف'),
            ])
            ->bulkActions([
                \Filament\Actions\DeleteBulkAction::make()
                    ->label('حذف المحدد'),
            ]);
    }
}
