<?php

use Livewire\Volt\Component;
use App\Models\AnnualCoursePlan;
use App\Models\Month;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

new class extends Component implements HasForms, HasTable {
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnualCoursePlan::where('user_id', auth()->id())->where('semester_id', $this->semester->id))
            ->columns([
                Tables\Columns\TextColumn::make('month_id')->hidden(true),
                Tables\Columns\TextColumn::make('month.name')
                    ->label('Bulan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pillar.code')
                    ->label('Tunjang')
                    ->searchable()
                    ->description(fn(AnnualCoursePlan $record): string => $record->pillar->name)
                    ->sortable(),
                Tables\Columns\TextColumn::make('standardContents.code')
                    ->label('Standard Kandungan')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('standardLessons.code')
                    ->label('Standard Pembelajaran')
                    ->badge()
                    ->separator(','),

                Tables\Columns\TextColumn::make('description')
                    ->searchable()
                    ->label('Catatan'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('month_id')
                    ->label('Bulan')
                    ->searchable()
                    ->native(false)
                    ->options(Month::all()->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->url(fn(AnnualCoursePlan $record): string => route('courses.edit', ['semester' => $this->semester, 'annualCourse' => $record])),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam Rancangan Tahunan')
                    ->requiresConfirmation()
                    ->action(fn(AnnualCoursePlan $record) => $record->delete()),
            ])
            ->defaultSort('month_id', 'ASC');
    }
};
?>

<div>
    @php
        $breadcrumb = [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('Rancangan Pelajaran'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Rancangan Pelajaran Tahunan') }}</h2>
            <div class="flex gap-2">
                <x-ui.link-primary
                    href="{{ route('courses.create', $semester) }}">{{ __('Tambah') }}</x-ui.link-primary>

            </div>
        </div>
        <div>
            {{ $this->table }}
        </div>
        <div class="flex justify-end mt-4">
            <livewire:modal-courses-list />
        </div>
    </div>
</div>
