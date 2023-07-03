<?php

namespace App\Filament\Resources\AppLinkResource\Pages;

use App\Filament\Resources\AppLinkResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageAppLinks extends ManageRecords
{
    protected static string $resource = AppLinkResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['user_id'] = auth()->user()->id;
                return $data;
            }),
        ];
    }
}
