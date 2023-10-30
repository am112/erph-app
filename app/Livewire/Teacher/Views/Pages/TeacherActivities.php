<?php

namespace App\Livewire\Teacher\Views\Pages;

use App\Livewire\Teacher\Services\TeacherActivitiesService;
use App\Livewire\Teacher\Views\Resources\TeacherActivitiesResource;
use App\Models\Semester;
use App\Models\Teacher;
use App\Models\TeacherActivity;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class TeacherActivities extends Component implements HasForms, HasTable {
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;
    public Teacher $teacher;

    public function mount(Semester $semester, Teacher $teacher): void
    {
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.teachers.activities.index', [
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
                'name' => __('PM / PPMS'),
                'href' => route('profile.teachers.index', $this->semester),
                'icon' => 'heroicon-m-academic-cap',
            ],
            [
                'name' => __('Kegiatan Sosial'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(TeacherActivity::query())
            ->columns(TeacherActivitiesResource::getTableColumns())
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah')
                    ->model(TeacherActivity::class)
                    ->modalHeading('Tambah Kegiatan Sosial')
                    ->form(TeacherActivitiesResource::getFormColumns())
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['teacher_id'] = $this->teacher->id;
                        return $data;
                    }),
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->modalHeading('Kemaskini Kegiatan Sosial')
                    ->form(TeacherActivitiesResource::getFormColumns()),
                DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam Kegiatan Sosial')
                    ->requiresConfirmation()
                    ->action(fn(TeacherActivity $record) => $record->delete()),
            ])
            ->defaultSort('name', 'ASC');
    }
};