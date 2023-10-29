<?php

namespace App\Livewire\Committee\Views\Resources;

use App\Models\Committee;
use App\Models\Semester;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Livewire\Component;

class CommitteeResource{

    public static function table(Table $table, Semester $semester): Table{
        return $table
            ->query(Committee::query())
            ->columns([
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
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make('Tambah')
                ->label('Tambah')
                ->closeModalByClickingAway(false)
                ->model(Committee::class)
                ->form(CommitteeResource::getFormColumn())
                ->mutateFormDataUsing(function (array $data) use($semester) : array {
                    $data['user_id'] = auth()->id();
                    $data['semester_id'] = $semester->id;
                    return $data;
                })
                ->after(function(Component $livewire){
                    $livewire->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
                }), 
            ])
            ->actions([
                EditAction::make()
                    ->label('')
                    ->closeModalByClickingAway(false)
                    ->form(CommitteeResource::getFormColumn())
                    ->after(function(Component $livewire){
                        $livewire->dispatch('toast', message: 'Data berjaya dikemaskini', data: ['position' => 'top-right', 'type' => 'success']);
                    }),                    
                DeleteAction::make()
                    ->label('')
                    ->modalHeading('Padam AJK')
                    ->requiresConfirmation()
                    ->action(fn(Committee $record) => $record->delete()),
            ])
            ->defaultSort('name', 'ASC');
    
    }

    public static function getFormColumn(): array{
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