<?php

namespace App\Livewire\Timetable\Views\Pages;

use App\Models\Rph;
use App\Models\Select;
use App\Models\Semester;
use App\Models\Timetable;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;

class EditTimetable extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];
    public Semester $semester;
    public Timetable $timetable;
    public Rph $rph;

    public function mount(Semester $semester, Rph $rph, Timetable $timetable): void
    {
        $this->semester = $semester;
        $this->rph = $rph;
        $this->timetable = $timetable;
        $this->form->fill($timetable->attributesToArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('date_at')
                    ->native(false)
                    ->required(),
                Forms\Components\DateTimePicker::make('start_time')
                    ->native(false)
                    ->date(false)
                    ->hoursStep(1)
                    ->minutesStep(5)
                    ->seconds(false)
                    ->displayFormat('H:i A'),
                Forms\Components\DateTimePicker::make('end_time')
                    ->native(false)
                    ->date(false)
                    ->hoursStep(1)
                    ->minutesStep(5)
                    ->seconds(false)
                    ->displayFormat('H:i A'),
                Forms\Components\Select::make('strategy_id')
                ->searchable()
                ->options(
                    Select::query()
                    ->where('type', 'strategy')
                    ->pluck('name','id'),
                ),
                Forms\Components\Select::make('field_id')
                ->searchable()
                ->options(
                    Select::query()
                    ->where('type', 'field')
                    ->pluck('name','id'),
                ),
                Forms\Components\Select::make('language_id')
                ->searchable()
                ->options(
                    Select::query()
                    ->where('type', 'language')
                    ->pluck('name','id'),
                ),
                Forms\Components\Select::make('discipline_id')
                ->searchable()
                ->options(
                    Select::query()
                    ->where('type', 'discipline')
                    ->pluck('name','id'),
                ),
                Forms\Components\Select::make('standard_id')
                ->searchable()
                ->options(
                    Select::query()
                    ->where('type', 'standard')
                    ->pluck('name','id'),
                ),
                Forms\Components\TextInput::make('objective')
                    ->maxLength(255),
                Forms\Components\TextInput::make('activity')
                    ->maxLength(255),
                Forms\Components\TextInput::make('remark')
                    ->maxLength(255),
                Forms\Components\TextInput::make('holiday')
                    ->maxLength(255),
            ])
            ->statePath('data')
            ->model($this->timetable);
    }

    public function update(): void
    {
        $data = $this->form->getState();
        $data['total_time'] = \Carbon\Carbon::createFromFormat('Y-m-d H:i', $data['date_at'] . $data['start_time'])->diffInMinutes(
            \Carbon\Carbon::createFromFormat('Y-m-d H:i', $data['date_at'] . $data['end_time'])
        );
        $this->timetable->update($data);
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            route('rph.index', $this->semester) => __('RPH'),
            route('rph.timetable.index', ['semester' => $this->semester, 'rph' => $this->rph]) => __('Jadual'),
            '' => __('Kemaskini'),
        ];
    }

    public function render(): View
    {
        return view('pages.timetables.edit-timetable');
    }
}
