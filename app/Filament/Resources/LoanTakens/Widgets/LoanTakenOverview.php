<?php

namespace App\Filament\Resources\LoanTakens\Widgets;

use App\Models\LoanTaken;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class LoanTakenOverview extends StatsOverviewWidget
{
    public string $Dashboard;


    protected function getStats(): array
    {
        $title=($this->Dashboard?'Loan Taken ':'');
        $totalAmount = LoanTaken::sum('amount');
        $totalReceived = LoanTaken::sum('amount_paid');

        // Pending is: amount - amount_paid (never less than zero)
        $totalPending = LoanTaken::selectRaw('SUM(CASE WHEN amount - amount_paid > 0 THEN amount - amount_paid ELSE 0 END) AS pending')
            ->value('pending');

        return [
            Stat::make($title . 'Total', $totalAmount),

            Stat::make($title . 'Pending Total', $totalPending?:0),

            Stat::make($title . 'Paid Total', $totalReceived),
        ];
    }
}
