<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLoanTaken extends EditRecord
{
    protected static string $resource = LoanTakenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
