<?php

namespace App\Filament\Resources\LoanGivens\Pages;

use App\Filament\Resources\LoanGivens\LoanGivenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListLoanGivens extends ListRecords
{
    protected static string $resource = LoanGivenResource::class;
    protected ?string $heading = 'Loans I Gave';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
