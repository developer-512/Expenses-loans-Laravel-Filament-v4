<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewLoanTaken extends ViewRecord
{
    protected static string $resource = LoanTakenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
            Action::make('back')
                ->label('Back to List')
                ->color('gray')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
