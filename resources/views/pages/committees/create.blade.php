<?php

use Livewire\Volt\Component;
use App\Models\committee;
use App\Models\Semester;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Forms\Get;
use Illuminate\Support\Facades\DB;
use App\Http\Services\CourseService;

new class extends Component implements HasForms {
    use InteractsWithForms;
    public Semester $semester;

    public ?array $data = [];
    public committee $record;

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('position')
                    ->label('Jawatan')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options([
                        'Pengurusi' => 'Pengurusi',
                        'Naib Pengurusi' => 'Naib Pengurusi',
                        'Penasihat' => 'Penasihat',
                    ]),
                Forms\Components\Textarea::make('address')
                    ->label('Alamat')
                    ->maxLength(255),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('No Tel.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('job')
                            ->label('Pekerjaan')
                            ->maxLength(255),
                    ]),
                ]),
            ])
            ->statePath('data')
            ->model($this->record ?? Committee::class);
    }

    public function create(): void
    {
        $data = $this->form->getState();

        // to be move to service class
        $data['user_id'] = auth()->id();
        $data['semester_id'] = $this->semester->id;
        Committee::create($data);

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
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
                'name' => __('Senarai AJK'),
                'href' => route('profile.committees.index', $semester),
                'icon' => 'heroicon-m-academic-cap',
            ],
            [
                'name' => __('Tambah'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />


    <div
        class="p-6 mt-6 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">
        <div class="mb-4 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                {{ __('Tambah Rancangan Pelajaran Tahunan') }}</h2>

        </div>

        <form wire:submit="create">
            {{ $this->form }}

            <div class="mt-6">
                <x-ui.button-primary type="submit">
                    {{ __('Tambah') }}
                </x-ui.button-primary>
            </div>

        </form>
        <x-filament-actions::modals />
    </div>
</div>
