<?php

namespace App\Livewire\Teacher\Views\Resources;

use App\Models\Teacher;
use App\Models\TeacherActivity;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeacherActivitiesResource{

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
        ];
    }

    public static function getFormColumns(): array
    {
        return [
            TextInput::make('name')
                ->label('Nama')
                ->required()
                ->maxLength(255),
            TextInput::make('position')
                ->label('Jawatan')
                ->required()
                ->maxLength(255),
        ];
    }
}