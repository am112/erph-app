<?php

namespace App\Livewire\Student\Views\Pages;

use App\Models\Month;
use App\Models\Semester;
use App\Models\StudentStatistic;
use Closure;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;

class ListStudent extends Component implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;
    public Semester $semester;

    public function mount($semester): void
    {
        $this->semester = $semester;
    }

    public function render(): View
    {
        return view('pages.students.list-student', [
            'breadcrumb' => $this->breadcrumb(),
        ]);
    }

    public function breadcrumb() : array
    {
        return [
            [
                'name' => __('Halaman Utama'),
                'href' => route('dashboard', $this->semester),
                'icon' => 'heroicon-s-home',
            ],
            [
                'name' => __('Maklumat Kanak Kanak'),
                'href' => '',
                'icon' => '',
            ],
        ];
    }


    public function table(Table $table): Table
    {
        $sumByYear =  function(Set $set, Get $get) {
            try{
                $sum = 0;
                $data = ['male_four', 'female_four','male_five','female_five','male_six','female_six'];
                foreach($data as $item){
                    if($get($item) != null){
                        $sum += $get($item);
                    }
                }                
                $set('total_by_year', $sum);
            }catch(\Exception $e){
                $set('total_by_year', 0);
            }
        };

        $sumByRace =  function(Set $set, Get $get) {
            try{
                $sum = 0;
                $data = ['melayu', 'cina','india','others'];
                foreach($data as $item){
                    if($get($item) != null){
                        $sum += $get($item);
                    }
                }                
                $set('total_by_race', $sum);
            }catch(\Exception $e){
                $set('total_by_race', 0);
            }
        };

        return $table
            ->query(StudentStatistic::query())
            ->columns([
                Tables\Columns\TextColumn::make('month.name')
                ->label('Bulan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('male_four')
                    ->label('4 Tahun - L')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('female_four')
                    ->label('4 Tahun - P')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('male_five')
                     ->label('5 Tahun - L')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('female_five')
                        ->label('5 Tahun - P')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('male_six')
                        ->label('6 Tahun - L')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('female_six')
                        ->label('6 Tahun - P')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('melayu')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('cina')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('india')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\TextColumn::make('others')
                    ->numeric()
                    ->alignCenter()
                    ->sortable(),
                Tables\Columns\ViewColumn::make('Total')
                    ->alignCenter()
                    ->sortable()
                ->view('filament.student-statistic-total'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make('createStudentStatistic')
                ->label('Tambah')
                ->form([
                    Select::make('month_id')
                        ->label('Bulan')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->options(Month::all()->pluck('name', 'id')),

                    Fieldset::make('Bil. Kanak-Kanak Mengikut Umur')
                        ->schema([
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_four')
                                    ->label('4 Tahun - L')
                                    ->numeric()
                                    ->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_four')
                                        ->label('4 Tahun - P')
                                        ->numeric()
                                        ->live()
                                        ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_five')
                                    ->label('5 Tahun - L')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_five')
                                    ->label('5 Tahun - P')
                                        ->numeric()->live()
                                        ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_six')
                                    ->label('6 Tahun - L')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_six')
                                    ->label('6 Tahun - P')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                        ])->columns(3),
                        
                    Fieldset::make('Bil. Kanak-Kanak Mengikut Kaum')
                        ->schema([
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('melayu')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                TextInput::make('cina')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('india')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                TextInput::make('others')
                                ->numeric()->live()
                                ->afterStateUpdated($sumByRace),
                                ]),
                            ]),
                    ])
                    ->columns(2),                
                    Group::make()->schema([
                        Grid::make(2)->schema([
                            TextInput::make('total_by_year')
                            ->label('Jumlah Mengikut Umur')
                            ->disabled(true)
                            ->same('total_by_race') ,
                            TextInput::make('total_by_race')
                            ->label('Jumlah Mengikut Kaum')
                            ->disabled(true)       
                            ->same('total_by_year')                  
                        ]),
                    ]),                                        
                ])
                ->closeModalByClickingAway(false)
                ->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    $data['semester_id'] = $this->semester->id;
                    return $data;
                })
            ])
            ->actions([
                EditAction::make()
                ->label('')
                ->form([
                    Select::make('month_id')
                        ->label('Bulan')
                        ->required()
                        ->native(false)
                        ->searchable()
                        ->options(Month::all()->pluck('name', 'id')),

                    Fieldset::make('Bil. Kanak-Kanak Mengikut Umur')
                        ->schema([
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_four')
                                    ->label('4 Tahun - L')
                                    ->numeric()
                                    ->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_four')
                                        ->label('4 Tahun - P')
                                        ->numeric()
                                        ->live()
                                        ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_five')
                                    ->label('5 Tahun - L')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_five')
                                    ->label('5 Tahun - P')
                                        ->numeric()->live()
                                        ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('male_six')
                                    ->label('6 Tahun - L')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                    TextInput::make('female_six')
                                    ->label('6 Tahun - P')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByYear),
                                ]),
                            ]),
                        ])->columns(3),
                        
                    Fieldset::make('Bil. Kanak-Kanak Mengikut Kaum')
                        ->schema([
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('melayu')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                TextInput::make('cina')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                ]),
                            ]),
                            Group::make()->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('india')
                                    ->numeric()->live()
                                    ->afterStateUpdated($sumByRace),
                                TextInput::make('others')
                                ->numeric()->live()
                                ->afterStateUpdated($sumByRace),
                                ]),
                            ]),
                    ])
                    ->columns(2),                
                    Group::make()->schema([
                        Grid::make(2)->schema([
                            TextInput::make('total_by_year')
                            ->disabled(true)
                            ->same('total_by_race') ,
                            TextInput::make('total_by_race')
                            ->disabled(true)       
                            ->same('total_by_year')                  
                        ]),
                    ]),                                        
                ])
                ->closeModalByClickingAway(false)
                ->mutateRecordDataUsing(function (array $data): array {
                    $sum = 0;
                    $header = ['male_four', 'female_four','male_five','female_five','male_six','female_six'];
                    foreach($header as $item){
                        if($data[$item] != null){
                            $sum += $data[$item];
                        }
                    }
                    $data['total_by_year'] = $sum;

                    $sum = 0;
                    $header = ['melayu', 'cina','india','others'];
                    foreach($header as $item){
                        if($data[$item] != null){
                            $sum += $data[$item];
                        }
                    }
                    $data['total_by_race'] = $sum;
                    return $data;
                }),
                DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam Rancangan Tahunan')
                    ->requiresConfirmation()
                    ->action(fn(StudentStatistic $record) => $record->delete()),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    //
                ]),
            ]);
    }
}
