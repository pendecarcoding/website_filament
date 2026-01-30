<?php

namespace App\Filament\Resources\MonografiResource\Pages;

use App\Filament\Resources\MonografiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMonografi extends EditRecord
{
    protected static string $resource = MonografiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
