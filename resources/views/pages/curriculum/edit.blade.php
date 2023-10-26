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

    public UserCurriculum $record;
    public Semester $semester;

    public ?array $data = [];

    public function mount(UserCurriculum $curricula, Semester $semester): void
    {
        $this->semester = $semester;
        $this->record = $curricula;
        $data = array_merge($this->record->attributesToArray(), ['accomplished' => $curricula->accomplished_at == null ? false : true]);
        $this->form->fill($data);
    }

    public function edit(): void
    {
        $data = $this->form->getState();
        (new CurriculaService($this->semester))->update($data, $this->record);
        $this->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('curricula_id')
                    ->label('Kokurikulum')
                    ->disabled()
                    ->native(false)
                    ->searchable()
                    ->options(Curricula::all()->pluck('name', 'id')),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Grid::make(3)->schema([
                        Forms\Components\DatePicker::make('plan_started_at')
                            ->label('Tarikh Mula Plan')
                            ->disabled()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        Forms\Components\DatePicker::make('plan_ended_at')
                            ->label('Tarikh Akhir Plan')
                            ->disabled()
                            ->native(false)
                            ->closeOnDateSelection()
                            ->suffixIcon('heroicon-s-calendar-days'),
                        Forms\Components\Select::make('week')
                            ->label('Minggu')
                            ->disabled()
                            ->native(false)
                            ->searchable()
                            ->options(Week::all()->pluck('name', 'id')),
                    ]),
                ]),
                Forms\Components\Toggle::make('accomplished')->label('Terlaksana'),
            ])
            ->statePath('data')
            ->model($this->record);
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
                'name' => __('Kemaskini'),
                'href' => '',
                'icon' => '',
            ],
        ];
    @endphp
    <x-layouts.app.breadcrumb :links="$breadcrumb" />
    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Kemaskini Kalendar Aktiviti') }}</h2>
    <div
        class="p-6 mt-5 max-w-4xl bg-white border border-gray-200 rounded-lg  shadow-sm dark:bg-gray-800 dark:border-gray-700 ">


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
