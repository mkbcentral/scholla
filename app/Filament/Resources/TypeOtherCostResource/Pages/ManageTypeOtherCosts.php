<?php

namespace App\Filament\Resources\TypeOtherCostResource\Pages;

use App\Filament\Resources\TypeOtherCostResource;
use App\Models\ScolaryYear;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTypeOtherCosts extends ManageRecords
{
    protected static string $resource = TypeOtherCostResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                $scolaryYear=ScolaryYear::where('active',true)->first();
                $data['school_id'] = auth()->user()->school->id;
                $data['school_scolary_year_id'] = $scolaryYear->id;
                return $data;
            }),
        ];
    }
}
