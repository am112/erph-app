<?php

use Livewire\Volt\Component;
use App\Models\Teacher;
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
    public Teacher $record;
    public $avatarExist = false;

    public ?array $data = [];

    public function mount($semester, Teacher $teacher): void
    {
        $this->semester = $semester;
        $this->record = $teacher;
        $this->avatarExist = $this->record->getFirstMedia() == null ? false : true;
        $data = $this->record->attributesToArray();
        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->avatarExist
                    ? Forms\Components\Placeholder::make('')
                    : Forms\Components\FileUpload::make('image')
                        ->label('Gambar')
                        ->avatar()
                        ->storeFiles(false)
                        ->imageEditor()
                        ->imageEditorAspectRatios(['1:1']),
                Forms\Components\TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('nric')
                            ->label('No KP.')
                            ->numeric()
                            ->required(),
                        // ->length(12),
                        Forms\Components\DatePicker::make('dob')
                            ->label('Tarikh Lahir')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->closeOnDateSelection(),
                    ]),
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Select::make('gender')
                            ->label('Jantina')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'Lelaki' => 'Lelaki',
                                'Perempuan' => 'Perempuan',
                            ]),
                        Forms\Components\Select::make('religion')
                            ->label('Agama')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'Islam' => 'Islam',
                                'Cristian' => 'Cristian',
                                'Budha' => 'Budha',
                            ]),
                        Forms\Components\Select::make('nationality')
                            ->label('Bangsa')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'Melayu' => 'Melayu',
                                'Asli' => 'Asli',
                                'Cina' => 'Cina',
                                'India' => 'India',
                            ]),
                    ]),
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\Select::make('job_status')
                            ->label('Status Perkhidmatan')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'Tetap' => 'Tetap',
                                'Kontrak' => 'Kontrak',
                            ]),
                        Forms\Components\Select::make('position')
                            ->label('Jawatan')
                            ->native(false)
                            ->required()
                            ->searchable()
                            ->options([
                                'PM' => 'PM',
                                'PPMS' => 'PPMS',
                                'PPM' => 'PPM',
                            ]),
                        Forms\Components\Select::make('gred')
                            ->label('Gred')
                            ->native(false)
                            ->searchable()
                            ->options([
                                'S19' => 'S19',
                                'S29' => 'S29',
                                'N11' => 'N11',
                            ]),
                    ]),
                ]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('phone')
                            ->label('No Tel.')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('email')
                            ->label('Alamat E-Mel')
                            ->maxLength(255),
                    ]),
                ]),
            ])
            ->statePath('data')
            ->model($this->record);
    }

    public function deleteAvatar()
    {
        $this->record->getFirstMedia()->delete();
        $this->avatarExist = false;
    }

    public function edit(): void
    {
        $data = $this->form->getState();
        // to be move to service class
        $data['type'] = $data['position'];
        if ($this->record->getFirstMedia() != null) {
            $this->deleteAvatar();
        }
        $this->record->addMedia($data['image'])->toMediaCollection();
        unset($data['image']);
        $this->record->update($data);

        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
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
                'name' => __('Senarai PM / PPMS'),
                'href' => route('profile.teachers.index', $semester),
                'icon' => 'heroicon-m-academic-cap',
            ],
            [
                'name' => __('Kemaskini'),
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
                {{ __('Kemaskini PM/PPMS') }}</h2>
        </div>
        @if ($avatarExist != null)
            <span class="text-sm font-medium leading-6 text-gray-950 dark:text-white">
                Gambar
            </span>
            <div class="relative w-32 h-32 mt-2">
                <img class="rounded-full border w-32 h-32" src="{{ $this->record->getFirstMedia()->getFullUrl() }}"
                    alt="Extra large avatar" />
                <x-heroicon-m-trash
                    class="absolute bottom-3 left-11 w-9 h-9 text-gray-200 cursor-pointer p-2 border rounded-full border-gray-600 hover:border-white bg-gray-700 opacity-80"
                    wire:click="deleteAvatar" />
            </div>
        @endif
        <form wire:submit="edit">
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
