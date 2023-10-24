<?php
use Livewire\Volt\Component;
use App\Models\Curricula;
use App\Models\Semester;
use App\Models\UserCurriculum;
use App\Models\Week;
use App\Http\Services\CurriculaService;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

new class extends Component implements HasForms {
    use InteractsWithForms;

    public Semester $semester;

    public ?array $data = [];

    public function mount($semester): void
    {
        $this->semester = $semester;
        $this->form->fill();
    }

    public function create(): void
    {
        $data = $this->form->getState();
        (new CurriculaService($this->semester))->create($data);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini.', data: ['position' => 'top-right', 'type' => 'success']);
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curricula_id')
                    ->label('Kokurikulum')
                    ->required()
                    ->native(false)
                    ->searchable()
                    ->options(Curricula::all()->pluck('name', 'id')),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\DatePicker::make('plan_started_at')
                            ->label('Tarikh Mula Plan')
                            ->required()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        Forms\Components\DatePicker::make('plan_ended_at')
                            ->label('Tarikh Akhir Plan')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        Forms\Components\Select::make('week')
                            ->label('Minggu')
                            ->required()
                            ->native(false)
                            ->searchable()
                            ->options(Week::all()->pluck('name', 'id')),
                    ]),
                ]),
            ])
            ->statePath('data')
            ->model(UserCurriculum::class);
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
                'name' => __('Kalendar Aktiviti'),
                'href' => route('curriculum.index', $semester),
                'icon' => 'heroicon-s-calendar-days',
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
        <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">{{ __('Tambah Kalendar Aktiviti') }}</h2>

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
