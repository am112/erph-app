<?php

namespace App\Livewire\Student\Views\Pages;

use App\Livewire\Student\Views\Resources\StudentResource;
use App\Models\Semester;
use App\Models\StudentStatistic;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

class ListStudent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
    }

    public function render(): View
    {
        return view('pages.students.list-student');
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('Kanak Kanak'),
        ];
    }


    public function table(Table $table): Table
    {
        return $table
            ->query(StudentStatistic::query())
            ->columns(StudentResource::getTableColumns())
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah')
                    ->createAnother(false)
                    ->modalHeading('Tambah Laporan Kanak-Kanak')
                    ->modalSubmitActionLabel('Tambah')
                    ->form(StudentResource::getFormColumns())
                    ->closeModalByClickingAway(false)
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['user_id'] = auth()->id();
                        $data['semester_id'] = $this->semester->id;
                        $data['total'] = StudentResource::calculateSum(StudentResource::COLUMN_YEAR, $data);
                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->modalHeading('Kemaskini Laporan Kanak-Kanak')
                    ->modalSubmitActionLabel('Simpan')
                    ->form(StudentResource::getFormColumns())
                    ->closeModalByClickingAway(false)
                    ->mutateRecordDataUsing(function (array $data): array {
                        $data['total_by_year'] = StudentResource::calculateSum(StudentResource::COLUMN_YEAR, $data);
                        $data['total_by_race'] = StudentResource::calculateSum(StudentResource::COLUMN_RACE, $data);;
                        return $data;
                    })
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['total'] = StudentResource::calculateSum(StudentResource::COLUMN_YEAR, $data);
                        return $data;
                    }),
                DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam Laporan Kanak-Kanak')
                    ->requiresConfirmation()
                    ->action(fn(StudentStatistic $record) => $record->delete()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
