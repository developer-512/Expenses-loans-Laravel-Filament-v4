<?php

namespace App\Filament\Resources\LoanGivens\Pages;

use App\Filament\Resources\LoanGivens\LoanGivenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanGiven extends CreateRecord
{
    protected static string $resource = LoanGivenResource::class;
    protected ?string $heading = 'Add Loan Given Details:';
    protected static ?string $navigationLabel = 'Add Loan Given Details';

    protected static ?string $breadcrumbLabel = 'Add Loan Given Details';
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
