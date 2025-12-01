<?php

namespace App\Filament\Resources\LoanGivens\Widgets;

use App\Models\LoanGiven;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LoanGivenOverview extends StatsOverviewWidget
{
    public string $Dashboard;
    protected function getStats(): array
    {
        $title = ($this->Dashboard ? 'Loan Given ' : '');

        $totalAmount = LoanGiven::sum('amount');
        $totalReceived = LoanGiven::sum('amount_paid');

        // Pending is: amount - amount_paid (never less than zero)
        $totalPending = LoanGiven::selectRaw('SUM(CASE WHEN amount - amount_paid > 0 THEN amount - amount_paid ELSE 0 END) AS pending')
            ->value('pending');

        return [
            Stat::make($title . 'Total', $totalAmount),

            Stat::make($title . 'Pending Total', $totalPending),

            Stat::make($title . 'Received Total', $totalReceived),
        ];
    }
}
