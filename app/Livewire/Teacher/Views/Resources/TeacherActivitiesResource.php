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

    public static function form(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('position')
                ->required()
                ->maxLength(255),
        ];
    }

    public static function getTable(Table $table, Teacher $teacher): Table{
        return $table
        ->query(TeacherActivity::query())
        ->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->searchable()
                ->sortable(),
            TextColumn::make('position')
                ->label('Jawatan')
                ->searchable()
                ->sortable(),
        ])
        ->filters([])
        ->headerActions([
            CreateAction::make()
                ->label('Tambah')
                ->model(TeacherActivity::class)
                ->modalHeading('Tambah Kegiatan Sosial')
                ->form(Self::form())
                ->mutateFormDataUsing(function (array $data) use($teacher): array {
                    $data['teacher_id'] = $teacher->id;
                    return $data;
                }),
        ])
        ->actions([
            EditAction::make()
                ->label('')
                ->modalHeading('Kemaskini Kegiatan Sosial')
                ->form(Self::form()),
            DeleteAction::make()
                ->label('')
                ->modalHeading('Padam AJK')
                ->requiresConfirmation()
                ->action(fn(TeacherActivity $record) => $record->delete()),
        ])
        ->defaultSort('name', 'ASC');
    }
}