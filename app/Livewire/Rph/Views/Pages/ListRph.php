<?php

namespace App\Livewire\Rph\Views\Pages;

use App\Models\Rph;
use App\Models\Semester;
use App\Models\Timetable;
use App\Models\Week;
use App\Services\FileService;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ListRph extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Semester $semester;
    public $media;

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
            route('dashboard', $this->semester) => __('Halaman Utama'),
            '' => __('RPH'),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Week::query()
                ->with([
                    'rph' => fn(Builder $query) => $query->createdBy()
                    ->semester($this->semester->id)
                    ->with('media')
                    ->withCount([
                        'timetables' => fn($query)=> $query->select(DB::raw('count(distinct(date_at))'))
                    ])
                ])
            )
            ->columns([
                TextColumn::make('name')
                ->label('Minggu')
                ->searchable()
                ->sortable(),
                ViewColumn::make('mind_map')
                ->label('Mind Map')
                ->alignCenter()
                ->view('filament.rph.table.column-mind-map'),
                ViewColumn::make('web_activity')
                ->label('Web Aktiviti')
                ->alignCenter()
                ->view('filament.rph.table.column-web-activity'),
                TextColumn::make('rph.timetables_count')
                ->label('Jumlah Jadual')
                ->alignCenter()

            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()
                ->label('')
                ->form([
                    FileUpload::make('mind_map')
                    ->storeFiles(false),
                    FileUpload::make('web_activity')
                    ->storeFiles(false),
                ])
                ->using(function(Model $record, array $data){
                    $rph = $record->rph;
                    if($rph === null){
                        $rph = Rph::create([
                            'user_id' => auth()->id(),
                            'semester_id' => $this->semester->id,
                            'week_id'=> $record->id,
                        ]);
                    }
                    if($data['mind_map'] != null){
                        (new FileService($rph))->storeToCollection($data['mind_map'], Rph::MEDIA_MIND_MAP, true);
                    }

                    if($data['web_activity'] != null){
                        (new FileService($rph))->storeToCollection($data['web_activity'], Rph::MEDIA_WEB_ACTIVITY, true);
                    }

                    return $record;
                }),
                Action::make('timetable')
                ->label(__('Jadual'))
                ->after(function(Component $livewire, Week $record){
                    if($record->rph == null){
                        $rph = Rph::create([
                            'user_id' => auth()->user()->id,
                            'semester_id' => $this->semester->id,
                            'week_id' => $record->id,
                        ]);
                        $livewire->redirect(route('rph.timetable.index', ['semester' => $this->semester, 'rph' => $rph->id]), false);
                        return;
                    }
                    $livewire->redirect(route('rph.timetable.index', ['semester' => $this->semester, 'rph' => $record->rph->id]), false);
                }),
            ])
            ->bulkActions([

            ]);
    }

    public function setMedia($media){
        $this->media = $media;
        $this->dispatch('open-modal', id: 'show-pdf');
    }
}
