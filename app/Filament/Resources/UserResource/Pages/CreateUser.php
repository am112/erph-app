<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $data['password'] = bcrypt($data['password']);        
    //     return $data;
    // }

    protected function handleRecordCreation(array $data): User
    {
        $roleId = $data['role_id'];
        unset($data['role_id']);
        $user = static::getModel()::create($data);
        $user->assignRole($roleId);
        return $user;
    }
}
