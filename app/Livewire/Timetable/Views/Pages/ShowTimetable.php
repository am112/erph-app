<?php

namespace App\Livewire\Timetable\Views\Pages;

use App\Models\Rph;
use App\Models\Semester;
use App\Models\Timetable;
use App\Models\TimetableSummary;
use Carbon\Carbon;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ShowTimetable extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Semester $semester;
    public Rph $rph;
    public $date_at;
    public $media;
    public array $data = [];
    public $record;

    public function mount(Semester $semester, Rph $rph, string $date_at): void
    {
        $rph->load('week');
        $this->semester = $semester;
        $this->rph = $rph;
        $this->date_at = Carbon::parse($date_at);
        $this->record = TimetableSummary::where('rph_id', $this->rph->id)->where('date_at', $this->date_at)->first();
        $this->form->fill($this->record === null ? [] : $this->record->attributesToArray());
    }
    public function render()
    {
        return view('pages.timetables.timetable-summary');
    }

    #[Computed]
    public function breadcrumb() : array
    {
        return [
            route('dashboard', $this->semester) => __('Halaman Utama'),
            route('rph.index', $this->semester) => __('RPH'),
            route('rph.timetable.index', ['semester' => $this->semester, 'rph' => $this->rph]) => __('Jadual'),
            '' => __($this->date_at->translatedFormat('d/m/Y (l)')),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Timetable::query()->where('rph_id', $this->rph->id)->where('date_at', $this->date_at))
            ->columns([
                TextColumn::make('total_time')
                ->description(fn(Timetable $record) :string => $record->start_time . ' - ' . $record->end_time),
                TextColumn::make('discipline.name'),
                TextColumn::make('standard.name'),
                TextColumn::make('objective'),
                TextColumn::make('activity'),
                TextColumn::make('remark'),
            ])
            ->filters([])
            ->headerActions([
            ])
            ->paginated(false)
            ->actions([])
            ->defaultSort('start_time', 'ASC');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([

                TextInput::make('student_reflect')
                    ->maxLength(255),
                TextInput::make('teacher_reflect')
                    ->maxLength(255),
                TextInput::make('supervisor_name')
                    ->maxLength(255),
                TextInput::make('supervisor_position')
                    ->maxLength(255),
                TextInput::make('supervisor_remark')
                    ->maxLength(255),

                TextInput::make('other')
                    ->maxLength(255),
            ])
            ->statePath('data')
            ->model(TimetableSummary::class);
    }

    public function update(){
        $data = $this->form->getState();
        if($this->record === null){
            $data['date_at'] = $this->date_at;
            $data['user_id'] = auth()->user()->id;
            $data['semester_id'] = $this->semester->id;
            $data['rph_id'] = $this->rph->id;
            TimetableSummary::create($data);
        }else{
            $this->record->update($data);
        }

    }
}
