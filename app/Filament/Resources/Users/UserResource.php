<?php

namespace App\Filament\Resources\Users;

use App\Models\User;
use App\Models\SkinAnalysis;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Filters\Filter;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use BackedEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $modelLabel = 'مستخدم';
    protected static ?string $pluralModelLabel = 'المستخدمون';
    protected static ?string $navigationLabel = 'المستخدمون';
    protected static ?string $breadcrumb = 'المستخدمون';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->width(60),

                TextColumn::make('name')
                    ->label('الاسم')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('email')
                    ->label('البريد الإلكتروني')
                    ->searchable()
                    ->copyable()
                    ->color('primary'),

                TextColumn::make('analyses_count')
                    ->label('عدد التحليلات')
                    ->counts('analyses')
                    ->badge()
                    ->color('info')
                    ->sortable(),

                TextColumn::make('latest_analysis')
                    ->label('آخر تحليل')
                    ->getStateUsing(function (User $record) {
                        $latest = SkinAnalysis::where('user_id', $record->id)
                            ->orderByDesc('created_at')
                            ->first();
                        return $latest ? $latest->created_at->format('d/m/Y') : 'لا يوجد';
                    })
                    ->color('gray'),

                TextColumn::make('latest_skin_type')
                    ->label('نوع البشرة')
                    ->getStateUsing(function (User $record) {
                        $latest = SkinAnalysis::where('user_id', $record->id)
                            ->orderByDesc('created_at')
                            ->first();
                        $map = ['Normal'=>'طبيعية','Dry'=>'جافة','Oily'=>'دهنية','Combination'=>'مختلطة','Sensitive'=>'حساسة'];
                        return $latest ? ($map[$latest->detected_skin_type] ?? $latest->detected_skin_type ?? '—') : '—';
                    })
                    ->badge()
                    ->color('warning'),

                TextColumn::make('latest_score')
                    ->label('درجة البشرة')
                    ->getStateUsing(function (User $record) {
                        $latest = SkinAnalysis::where('user_id', $record->id)
                            ->orderByDesc('created_at')
                            ->first();
                        if ($latest && $latest->global_scores) {
                            return round(array_sum($latest->global_scores) / count($latest->global_scores)) . '/100';
                        }
                        return '—';
                    })
                    ->badge()
                    ->color('success'),

                TextColumn::make('created_at')
                    ->label('تاريخ التسجيل')
                    ->date('d/m/Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Filter::make('has_analyses')
                    ->label('لديهم تحليلات')
                    ->query(fn ($query) => $query->has('analyses')),

                Filter::make('no_analyses')
                    ->label('بدون تحليلات')
                    ->query(fn ($query) => $query->doesntHave('analyses')),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
        ];
    }
}
