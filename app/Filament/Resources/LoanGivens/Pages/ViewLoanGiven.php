<?php

namespace App\Filament\Resources\LoanGivens\Pages;

use App\Filament\Resources\LoanGivens\LoanGivenResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLoanGiven extends ViewRecord
{
    protected static string $resource = LoanGivenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
