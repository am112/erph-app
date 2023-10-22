<?php

namespace App\Livewire\Pages\Courses;

use App\Models\AnnualCoursePlan;
use App\Models\Month;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListCourse extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnualCoursePlan::where('user_id', auth()->id())->where('semester_id', $this->semester->id))
            ->columns([
                Tables\Columns\TextColumn::make('month_id')
                ->hidden(true),
                Tables\Columns\TextColumn::make('month.name')
                    ->label('Bulan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pillar.code')
                    ->label('Tunjang')
                    ->searchable()
                    ->description(fn (AnnualCoursePlan $record): string => $record->pillar->name)
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
                ->url(fn (AnnualCoursePlan $record): string => route('semester.courses.edit', ['semester' => $this->semester, 'annualCourse' => $record])),
                Tables\Actions\DeleteAction::make()
                ->label('')
                ->modalHeading('Padam Rancangan Tahunan')
                ->requiresConfirmation()
                ->action(fn (AnnualCoursePlan $record) => $record->delete()),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ])
            ->defaultSort('month_id', 'ASC');
    }

    public function render(): View
    {
        return view('pages.courses.index');
    }
}
