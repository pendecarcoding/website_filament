<?php

namespace App\Filament\Resources\MonografiResource\Pages;

use App\Filament\Resources\MonografiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMonografis extends ListRecords
{
    protected static string $resource = MonografiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
