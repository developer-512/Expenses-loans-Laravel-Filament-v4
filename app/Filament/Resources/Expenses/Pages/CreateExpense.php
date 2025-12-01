<?php

namespace App\Filament\Resources\Expenses\Pages;

use App\Filament\Resources\Expenses\ExpenseResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;
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
