<?php

namespace App\Livewire\Student\Views\Resources;

use App\Models\Month;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\Summarizers\Summarizer;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

class StudentResource{

    public const COLUMN_YEAR = ['male_four', 'female_four','male_five','female_five','male_six','female_six'];
    public const COLUMN_RACE = ['melayu', 'cina','india','others'];

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('month.name')
                ->label('Bulan')
                ->numeric()
                ->sortable(),
            TextColumn::make('male_four')
                ->label('4 Tahun - L')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('female_four')
                ->label('4 Tahun - P')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('male_five')
                 ->label('5 Tahun - L')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('female_five')
                ->label('5 Tahun - P')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('male_six')
                ->label('6 Tahun - L')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('female_six')
                ->label('6 Tahun - P')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('melayu')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('cina')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('india')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('others')
                ->label('Lain - Lain')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            TextColumn::make('total')
                ->label('Lain - Lain')
                ->numeric()
                ->alignCenter()
                ->sortable()
                ->summarize(Sum::make()->label('')),
            // ViewColumn::make('total')
            //     ->label('Jumlah')
            //     ->alignCenter()
            //     ->sortable()
            //     ->view('filament.student-statistic-total')
            //     ->summarize(Summarizer::make()
            //         ->label('')
            //         ->using(fn (Builder $query): string => $query->sum(DB::raw('melayu + cina + india + others')))
            //     ),
            TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ];
    }

    public static function getFormColumns(): array
    {
        return [
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
                        ->afterStateUpdated(function(Set $set, Get $get){
                            $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                        }),
                        TextInput::make('female_four')
                            ->label('4 Tahun - P')
                            ->numeric()
                            ->live()
                            ->afterStateUpdated(function(Set $set, Get $get){
                                $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                            }),
                    ]),
                ]),
                Group::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('male_five')
                        ->label('5 Tahun - L')
                        ->numeric()->live()
                        ->afterStateUpdated(function(Set $set, Get $get){
                            $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                        }),
                        TextInput::make('female_five')
                        ->label('5 Tahun - P')
                            ->numeric()->live()
                            ->afterStateUpdated(function(Set $set, Get $get){
                                $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                            }),
                    ]),
                ]),
                Group::make()->schema([
                    Grid::make(2)->schema([
                        TextInput::make('male_six')
                        ->label('6 Tahun - L')
                        ->numeric()->live()
                        ->afterStateUpdated(function(Set $set, Get $get){
                            $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                        }),
                        TextInput::make('female_six')
                        ->label('6 Tahun - P')
                        ->numeric()->live()
                        ->afterStateUpdated(function(Set $set, Get $get){
                            $set('total_by_year', Self::calculateSum(self::COLUMN_YEAR, $get));
                        }),
                    ]),
                ]),
            ])->columns(3),
            
        
            Fieldset::make('Bil. Kanak-Kanak Mengikut Kaum')
                ->schema([
                    Group::make()->schema([
                        Grid::make(2)->schema([
                            TextInput::make('melayu')
                            ->numeric()->live()
                            ->afterStateUpdated(function(Set $set, Get $get){
                                $set('total_by_race', Self::calculateSum(self::COLUMN_RACE, $get));
                            }),
                        TextInput::make('cina')
                            ->numeric()->live()
                            ->afterStateUpdated(function(Set $set, Get $get){
                                $set('total_by_race', Self::calculateSum(self::COLUMN_RACE, $get));
                            }),
                        ]),
                    ]),
                    Group::make()->schema([
                        Grid::make(2)->schema([
                            TextInput::make('india')
                            ->numeric()->live()
                            ->afterStateUpdated(function(Set $set, Get $get){
                                $set('total_by_race', Self::calculateSum(self::COLUMN_RACE, $get));
                            }),
                        TextInput::make('others')
                        ->numeric()->live()
                        ->afterStateUpdated(function(Set $set, Get $get){
                            $set('total_by_race', Self::calculateSum(self::COLUMN_RACE, $get));
                        }),
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
        ];
    }

    public static function calculateSum($header, Get|array $data): int
    {
        try{
            $sum = 0;            
            foreach($header as $item){
                if(is_array($data)){
                    if($data[$item] != null){
                        $sum += $data[$item];
                    }
                }else{
                    if($data($item) != null){
                        $sum += $data($item);
                    }
                }                
            }                
            return $sum;
        }catch(\Exception $e){
            return 0;
        }
    }
}