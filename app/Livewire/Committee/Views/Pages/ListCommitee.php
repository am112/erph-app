<?php

namespace App\Livewire\Committee\Views\Pages;

use App\Livewire\Committee\Views\Resources\CommitteeResource;
use App\Models\Committee;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;

class ListCommitee extends Component implements HasForms, HasTable {
    use InteractsWithForms;
    use InteractsWithTable;

    public Semester $semester;

    public function mount(Semester $semester): void
    {
        $this->semester = $semester;
    }

    public function render()
    {
        return view('pages.committees.list-committee', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('Ahli Jawatankuasa'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Committee::query())
            ->columns(CommitteeResource::getTableColumns())
            ->filters([])
            ->headerActions([
                CreateAction::make('Tambah')
                ->label('Tambah')
                ->closeModalByClickingAway(false)
                ->model(Committee::class)
                ->form(CommitteeResource::getFormColumns())
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    $data['semester_id'] = $this->semester->id;
                    return $data;
                })
                ->after(function(Component $livewire){
                    $livewire->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
                }),
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->closeModalByClickingAway(false)
                    ->form(CommitteeResource::getFormColumns())
                    ->after(function(Component $livewire){
                        $livewire->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
                    }),
                DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam AJK')
                    ->requiresConfirmation()
                    ->action(fn(Committee $record) => $record->delete()),
            ])
            ->defaultSort('name', 'ASC');
    }
}
