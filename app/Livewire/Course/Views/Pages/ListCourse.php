<?php

namespace App\Livewire\Course\Views\Pages;

use App\Models\AnnualCoursePlan;
use App\Models\Month;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListCourse extends Component implements HasForms, HasTable {
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.courses.list-course', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $this->semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('Rancangan Pelajaran'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnualCoursePlan::semester($this->semester->id))
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
            ->headerActions([
                Action::make('Add')
                ->label('Tambah')
                ->after(function(Component $livewire){
                    $livewire->redirect(route('courses.create', $this->semester));
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->after(function(Component $livewire, AnnualCoursePlan $record){
                        $livewire->redirect(route('courses.edit', ['semester' => $this->semester, 'annualCourse' => $record]), false);
                    }),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam Rancangan Tahunan')
                    ->requiresConfirmation()
                    ->action(fn(AnnualCoursePlan $record) => $record->delete()),
            ])
            ->defaultSort('month_id', 'ASC');
    }
}