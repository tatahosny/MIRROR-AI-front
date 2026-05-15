<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;

class ProductForm
{
    public static function make(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('معلومات المنتج')
                    ->schema([
                        Select::make('category_id')
                            ->label('التصنيف')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->label('اسم التصنيف')
                                    ->required(),
                            ]),

                        TextInput::make('name')
                            ->label('اسم المنتج')
                            ->required()
                            ->maxLength(200),

                        Textarea::make('description')
                            ->label('الوصف')
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        TextInput::make('price')
                            ->label('السعر')
                            ->required()
                            ->numeric()
                            ->prefix('$'),

                        TextInput::make('stock')
                            ->label('الكمية')
                            ->numeric()
                            ->default(0),

                        FileUpload::make('image_url')
                            ->label('صورة المنتج')
                            ->image()
                            ->directory('products')
                            ->maxSize(2048)
                            ->imageEditor()
                            ->imageEditorMode(2),

                        RichEditor::make('ingredients')
                            ->label('المكونات')
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'bulletList',
                                'orderedList',
                            ])
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('نشط')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }
}
