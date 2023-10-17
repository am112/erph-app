<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        unset($data['password']);
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $roleId = $data['role_id'];
        unset($data['role_id']);
        
        $record->update($data);
        $record->assignRole($roleId);
        return $record;
    }
}
