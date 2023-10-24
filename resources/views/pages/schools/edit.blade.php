<?php

use Livewire\Volt\Component;
use App\Models\School;
use App\Models\Semester;
use App\Models\Region;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\SchoolService;

new class extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;

    public ?array $data = [];
    public $record;

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
        if (auth()->user()->school != null) {
            $this->record = Auth::user()->school;
            $this->form->fill($this->record->attributesToArray());
        }
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\TextInput::make('code')
                            ->label('No. Daftar Kelas (SMPK)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name')
                            ->label('Nama TABIKA')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(2),
                    ]),
                ]),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat TABIKA')
                    ->maxLength(255),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('region')
                            ->label('Daerah')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('postcode')
                            ->label('Poskod')
                            ->maxLength(255),
                    ]),
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Select::make('state_id')
                            ->label('Negeri')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(
                                Region::select('id', 'name')
                                    ->state()
                                    ->get()
                                    ->pluck('name', 'id'),
                            ),
                        Forms\Components\Select::make('parliment_id')
                            ->label('Parlimen / Zon')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(
                                fn(Get $get): array => Region::select('id', 'name')
                                    ->where('parent_id', $get('state_id'))
                                    ->whereNotNull('parent_id')
                                    ->parliment()
                                    ->get()
                                    ->pluck('name', 'id')
                                    ->toArray(),
                            ),
                    ]),
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(4)->schema([
                        Forms\Components\Select::make('dun_id')
                            ->label('Dun / Zon')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(
                                fn(Get $get): array => Region::select('id', 'name')
                                    ->where('parent_id', $get('parliment_id'))
                                    ->whereNotNull('parent_id')
                                    ->dun()
                                    ->get()
                                    ->pluck('name', 'id')
                                    ->toArray(),
                            )
                            ->columnSpan(2),
                        Forms\Components\TextInput::make('phone')
                            ->label('No. Telefon TABIKA')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('established_at')
                            ->label('Tahun Ditubuhkan')
                            ->maxLength(255),
                    ]),
                ]),
            ])
            ->statePath('data')
            ->model($this->record ?? School::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();
        try {
            (new SchoolService())->update($data, $this->record);
            $this->dispatch('toast', message: 'Data berjaya dikemaskini.', data: ['position' => 'top-right', 'type' => 'success']);
        } catch (\Exception $e) {
            $this->dispatch('toast', message: 'Kesilapan! Sila cuba lagi.', data: ['position' => 'top-right', 'type' => 'danger']);
        }
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
                'name' => __('Tabika'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />

    <div
        class="p-6 mt-6 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __('Kemaskini Maklumat Tabika') }}</h2>

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Kemaskini') }}
                </x-ui.button-primary>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
