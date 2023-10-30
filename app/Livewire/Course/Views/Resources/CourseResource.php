<?php

namespace App\Livewire\Course\Views\Resources;

use App\Models\AnnualCoursePlan;
use App\Models\Course;
use App\Models\Month;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Get;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\DB;

class CourseResource
{
    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('month_id')->hidden(true),
            TextColumn::make('month.name')
                ->label('Bulan')
                ->searchable()
                ->sortable(),
            TextColumn::make('pillar.code')
                ->label('Tunjang')
                ->searchable()
                ->description(fn(AnnualCoursePlan $record): string => $record->pillar->name)
                ->sortable(),
            TextColumn::make('standardContents.code')
                ->label('Standard Kandungan')
                ->badge()
                ->separator(','),

            TextColumn::make('standardLessons.code')
                ->label('Standard Pembelajaran')
                ->badge()
                ->separator(','),

            TextColumn::make('description')
                ->searchable()
                ->label('Catatan'),
        ];
    }

    public static function getFormColumns(): array
    {
        return [
            Group::make()->schema([
                Grid::make(2)->schema([
                    Select::make('month_id')
                        ->label('Bulan')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->options(Month::all()->pluck('name', 'id')),
                ]),
            ]),
            Select::make('pillar_id')
                ->label('Tunjang')
                ->required()
                ->native(false)
                ->searchable()
                ->options(
                    Course::select('id', DB::raw("concat(code, ' - ', name) as codename"))
                        ->tunjang()
                        ->get()
                        ->pluck('codename', 'id'),
                ),
            Group::make()->schema([
                Grid::make(2)->schema([
                    Select::make('standard_contents_id')
                        ->label('Standard Kandungan')
                        ->required()
                        ->multiple()
                        ->native(false)
                        ->searchable()
                        ->options(
                            fn(Get $get): array => Course::query()
                                ->where('parent_id', $get('pillar_id'))
                                ->whereNotNull('parent_id')
                                ->get()
                                ->pluck('code', 'id')
                                ->toArray(),
                        ),

                    Select::make('standard_lessons_id')
                        ->label('Standard Pembelajaran')
                        ->required()
                        ->multiple()
                        ->native(false)
                        ->searchable()
                        ->options(
                            fn(Get $get): array => Course::whereIn('parent_id', $get('standard_contents_id'))
                                ->whereNotNull('parent_id')
                                ->get()
                                ->pluck('code', 'id')
                                ->toArray(),
                        ),
                ]),
            ]),
            Textarea::make('description')
                ->label('Catatan')
                ->maxLength(255),
        ];
    }
}