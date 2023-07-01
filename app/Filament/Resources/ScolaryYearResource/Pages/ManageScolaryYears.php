<?php

namespace App\Filament\Resources\ScolaryYearResource\Pages;

use App\Filament\Resources\ScolaryYearResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageScolaryYears extends ManageRecords
{
    protected static string $resource = ScolaryYearResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $data['school_id'] = auth()->user()->school->id;
                return $data;
            }),
        ];
    }
}
