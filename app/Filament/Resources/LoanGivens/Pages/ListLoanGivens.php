<?php

namespace App\Filament\Resources\LoanGivens\Pages;

use App\Filament\Resources\LoanGivens\LoanGivenResource;
use App\Filament\Resources\LoanGivens\Widgets\LoanGivenOverview;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListLoanGivens extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = LoanGivenResource::class;
    protected ?string $heading = 'Loans I Gave';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            LoanGivenOverview::make(['Dashboard'=>false]),
        ];
    }
}
