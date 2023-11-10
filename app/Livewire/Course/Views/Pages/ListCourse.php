<?php

namespace App\Livewire\Course\Views\Pages;

use App\Livewire\Course\Views\Resources\CourseResource;
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
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('Rancangan Pelajaran'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(AnnualCoursePlan::semester($this->semester->id))
            ->columns(CourseResource::getTableColumns())
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
