<?php

use Livewire\Volt\Component;
use App\Models\Committee;
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
            ->query(Committee::query())
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('position')
                    ->label('Jawatan')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->label('Alamat')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('No Tel')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('job')
                    ->label('Pekerjaan')
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->label('')
                    ->url(fn(Committee $record): string => route('profile.committees.edit', ['semester' => $this->semester, 'committee' => $record])),
                Tables\Actions\DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam AJK')
                    ->requiresConfirmation()
                    ->action(fn(Committee $record) => $record->delete()),
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
                'name' => __('Ahli Jawatankuasa'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div class="p-6 mt-6 bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="flex justify-between items-center text-center mb-8">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Ahli Jawatankuasa') }}</h2>
            <div class="flex gap-2">
                <x-ui.link-primary
                    href="{{ route('profile.committees.create', $semester) }}">{{ __('Tambah') }}</x-ui.link-primary>

            </div>
        </div>
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
