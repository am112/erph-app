<?php

namespace App\Livewire\School\Views\Resources;

use App\Models\Region;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;

class SchoolResource
{
    public static function getFormColumns(): array 
    {
        return [
            Group::make()->schema([
                Grid::make(3)->schema([
                    TextInput::make('code')
                        ->label('No. Daftar Kelas (SMPK)')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('name')
                        ->label('Nama TABIKA')
                        ->required()
                        ->maxLength(255)
                        ->columnSpan(2),
                ]),
            ]),
            Textarea::make('address')
                ->label('Alamat TABIKA')
                ->maxLength(255),
            Group::make()->schema([
                Grid::make(2)->schema([
                    TextInput::make('region')
                        ->label('Daerah')
                        ->maxLength(255),
                    TextInput::make('postcode')
                        ->label('Poskod')
                        ->maxLength(255),
                ]),
            ]),
            Group::make()->schema([
                Grid::make(2)->schema([
                    Select::make('state_id')
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
                    Select::make('parliment_id')
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
            Group::make()->schema([
                Grid::make(4)->schema([
                    Select::make('dun_id')
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
                    TextInput::make('phone')
                        ->label('No. Telefon TABIKA')
                        ->maxLength(255),
                    TextInput::make('established_at')
                        ->label('Tahun Ditubuhkan')
                        ->maxLength(255),
                ]),
            ]),
        ];
    }
}