<?php

namespace App\Filament\Resources\LoanGivens\Pages;

use App\Filament\Resources\LoanGivens\LoanGivenResource;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditLoanGiven extends EditRecord
{
    protected static string $resource = LoanGivenResource::class;
    protected ?string $heading = 'Edit Loan Given Details:';
    protected static ?string $navigationLabel = 'Edit Loan Given Details';

    protected static ?string $breadcrumbLabel = 'Edit Loan Given Details';
    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
            Action::make('back')
                ->label('Back to List')
                ->color('gray')
                ->icon('heroicon-o-arrow-left')
                ->url(static::getResource()::getUrl('index')),
        ];
    }
}
