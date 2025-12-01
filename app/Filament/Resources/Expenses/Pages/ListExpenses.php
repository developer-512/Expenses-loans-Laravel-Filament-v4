<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use App\Filament\Resources\Expenses\Widgets\ExpenseOverview;
use Filament\Actions\CreateAction;
use Filament\Pages\Concerns\ExposesTableToWidgets;
use Filament\Resources\Pages\ListRecords;

class ListExpenses extends ListRecords
{
    use ExposesTableToWidgets;
    protected static string $resource = ExpenseResource::class;
    protected ?string $heading = 'Expenses';
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            ExpenseOverview::make(['Dashboard'=>false]),
        ];
    }
}
