<?php

namespace App\Livewire\Teacher\Views\Pages;

use App\Livewire\Teacher\Views\Resources\TeacherResource;
use Livewire\Component;
use App\Models\Teacher;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;


class ListTeacher extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.teachers.list-teacher', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('PM / PPMS'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Teacher::query())
            ->columns(TeacherResource::getTableColumns())
            ->filters([])
            ->headerActions([
                $this->getCreateAction(),
            ])
            ->actions($this->getTableColumnActions())
            ->defaultSort('name', 'ASC');
    }

    protected function getTableColumnActions(): array
    {
        return [
            Tables\Actions\Action::make('social')
                ->label('Kegiatan Sosial')
                ->icon('heroicon-o-clipboard-document-list')
                ->url(fn(Teacher $record): string => route('profile.teachers.activities.index', ['semester' => $this->semester, 'teacher' => $record]))
                ->hidden(fn(Teacher $record): bool => $record->type !== 'PM'),
            Tables\Actions\EditAction::make()
                ->label('')
                ->url(fn(Teacher $record): string => route('profile.teachers.edit', ['semester' => $this->semester, 'teacher' => $record])),
            Tables\Actions\DeleteAction::make()
                ->label('')
                ->modalHeading('Padam AJK')
                ->requiresConfirmation()
                ->action(fn(Teacher $record) => $record->delete()),
        ];
    }

    protected function getCreateAction(): CreateAction
    {
        return CreateAction::make()
            ->label('Tambah')
            ->url(route('profile.teachers.create', ['semester' => $this->semester]));
    }

}
