<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use App\Filament\Resources\LoanTakens\Widgets\LoanTakenOverview;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListLoanTakens extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = LoanTakenResource::class;
    protected ?string $heading = 'Loans I Took';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            LoanTakenOverview::make(['Dashboard'=>false]),
        ];
    }
}
