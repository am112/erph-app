<?php

namespace App\Livewire\Rph\Views\Pages;

use App\Models\Semester;
use App\Models\Week;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListRph extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
    }
    public function render()
    {
        return view('pages.rph.list-rph');
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $this->semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('RPH'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Week::query())
            ->columns([
                TextColumn::make('name')
                ->label('Minggu'),
            ])
            ->filters([
                //
            ])            
            ->headerActions([
                
            ])
            ->actions([                
            ])
            ->bulkActions([
                
            ]);
    }
}
