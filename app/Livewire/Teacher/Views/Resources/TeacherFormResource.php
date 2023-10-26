<?php

namespace App\Livewire\Teacher\Views\Resources;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class TeacherFormResource {
    public static function columns(bool $avatar): array{
        return [
            $avatar
            ? Placeholder::make('')
            : FileUpload::make('image')
                    ->label('Gambar')
                    ->avatar()
                    ->storeFiles(false)
                    ->imageEditor()
                    ->imageEditorAspectRatios(['1:1']),
            TextInput::make('name')
                    ->label('Nama')
                    ->required()
                    ->maxLength(255),
            Group::make()->schema([
                Grid::make(2)->schema([
                    TextInput::make('nric')
                        ->label('No KP.')
                        ->numeric()
                        ->required(),
                    DatePicker::make('dob')
                        ->label('Tarikh Lahir')
                        ->native(false)
                        ->displayFormat('d/m/Y')
                        ->closeOnDateSelection(),
                ]),
            ]),
            Group::make()->schema([
                Grid::make(3)->schema([
                    Select::make('gender')
                        ->label('Jantina')
                        ->native(false)
                        ->searchable()
                        ->options([
                            'Lelaki' => 'Lelaki',
                            'Perempuan' => 'Perempuan',
                        ]),
                    Select::make('religion')
                        ->label('Agama')
                        ->native(false)
                        ->searchable()
                        ->options([
                            'Islam' => 'Islam',
                            'Cristian' => 'Cristian',
                            'Budha' => 'Budha',
                        ]),
                    Select::make('nationality')
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
            Group::make()->schema([
                Grid::make(3)->schema([
                    Select::make('job_status')
                        ->label('Status Perkhidmatan')
                        ->native(false)
                        ->searchable()
                        ->options([
                            'Tetap' => 'Tetap',
                            'Kontrak' => 'Kontrak',
                        ]),
                    Select::make('position')
                        ->label('Jawatan')
                        ->native(false)
                        ->required()
                        ->searchable()
                        ->options([
                            'PM' => 'PM',
                            'PPMS' => 'PPMS',
                            'PPM' => 'PPM',
                        ]),
                    Select::make('gred')
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
            Group::make()->schema([
                Grid::make(2)->schema([
                    TextInput::make('phone')
                        ->label('No Tel.')
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Alamat E-Mel')
                        ->maxLength(255),
                ]),
            ]),
        ];
    }
}