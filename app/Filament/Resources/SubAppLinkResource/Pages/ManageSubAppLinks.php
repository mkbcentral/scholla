<?php

namespace App\Filament\Resources\SubAppLinkResource\Pages;

use App\Filament\Resources\SubAppLinkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageSubAppLinks extends ManageRecords
{
    protected static string $resource = SubAppLinkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
