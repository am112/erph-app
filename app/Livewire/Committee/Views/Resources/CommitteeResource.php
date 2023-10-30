<?php

namespace App\Livewire\Committee\Views\Resources;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CommitteeResource{

    public static function getTableColumns(): array
    {
        return [
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),
            TextColumn::make('position')
                ->label('Jawatan')
                ->searchable()
                ->sortable(),
            TextColumn::make('address')
                ->label('Alamat')
                ->searchable()
                ->sortable(),
            TextColumn::make('phone')
                ->label('No Tel')
                ->searchable()
                ->sortable(),
            TextColumn::make('job')
                ->label('Pekerjaan')
                ->searchable()
                ->sortable(),            
        ];
    }

    public static function getFormColumns(): array{
        return [
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            Select::make('position')
                ->label('Jawatan')
                ->required()
                ->native(false)
                ->searchable()
                ->options([
                    'Pengurusi' => 'Pengurusi',
                    'Naib Pengurusi' => 'Naib Pengurusi',
                    'Penasihat' => 'Penasihat',
                ]),
            Textarea::make('address')
                ->label('Alamat')
                ->maxLength(255),
            Group::make()->schema([
                Grid::make(2)->schema([
                    TextInput::make('phone')
                        ->label('No Tel.')
                        ->maxLength(255),
                    TextInput::make('job')
                        ->label('Pekerjaan')
                        ->maxLength(255),
                ]),
            ]),
        ];
    }
}