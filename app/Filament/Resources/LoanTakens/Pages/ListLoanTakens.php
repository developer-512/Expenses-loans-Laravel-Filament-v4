<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLoanTakens extends ListRecords
{
    protected static string $resource = LoanTakenResource::class;
    protected ?string $heading = 'Loans I Took';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
