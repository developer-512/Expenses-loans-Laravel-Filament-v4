<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanTaken extends CreateRecord
{
    protected static string $resource = LoanTakenResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
