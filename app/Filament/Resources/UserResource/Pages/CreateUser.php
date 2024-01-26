<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        DB::statement('CALL sp_insert_user(?, ?, ?, @last_id)', [$data['name'], $data['email'], $data['password']]);
        
        $last_id = DB::scalar('SELECT @last_id');
        
        $user = User::find($last_id);

        return $user;
    }
}
