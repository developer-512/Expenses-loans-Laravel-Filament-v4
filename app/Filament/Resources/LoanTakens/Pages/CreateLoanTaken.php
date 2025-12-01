<?php

namespace App\Filament\Resources\LoanTakens\Pages;

use App\Filament\Resources\LoanTakens\LoanTakenResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateLoanTaken extends CreateRecord
{
    protected static string $resource = LoanTakenResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('Back to List')
                ->color('gray')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
