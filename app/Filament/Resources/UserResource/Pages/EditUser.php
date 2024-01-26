<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->action(function (User $record, Actions\DeleteAction $action) {
                    DB::statement('CALL sp_delete_user(?)', [$record->getKey()]);

                    return $action->success();
                }),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        DB::statement('CALL sp_update_user(?, ?, ?)', [$record->getKey(), $data['name'], $data['email']]);
       
        $record->refresh();
        
        return $record;
    }
}
