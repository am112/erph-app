<?php

use Livewire\Volt\Component;
use App\Models\Teacher;
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
            ->query(Teacher::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jawatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nric')
                    ->label('No KP.')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gender')
                    ->label('Jantina')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job_status')
                    ->label('Status Perkhidmatan')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->url(fn(Teacher $record): string => route('profile.teachers.edit', ['semester' => $this->semester, 'teacher' => $record])),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam AJK')
                    ->requiresConfirmation()
                    ->action(fn(Teacher $record) => $record->delete()),
            ])
            ->defaultSort('name', 'ASC');
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
                'name' => __('PM / PPMS'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('PM / PPMS') }}</h2>
            <div class="flex gap-2">
                <x-ui.link-primary
                    href="{{ route('profile.teachers.create', $semester) }}">{{ __('Tambah') }}</x-ui.link-primary>

            </div>
        </div>
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
