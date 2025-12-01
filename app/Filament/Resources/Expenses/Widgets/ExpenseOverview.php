<?php

namespace App\Filament\Resources\Expenses\Widgets;

use App\Models\Expense;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class ExpenseOverview extends StatsOverviewWidget
{
    public string $Dashboard;
    protected function getStats(): array
    {
        $title=($this->Dashboard?'Expenses ':'');
        return [
//            Stat::make('Total Expenses', Expense::sum('amount')),
            Stat::make($title.'This Month', Expense::whereMonth('date', now()->month)->sum('amount')),
            Stat::make($title.'Credit Card This Month', Expense::whereMonth('date', now()->month)->where('source', 'Credit Card')->sum('amount')),
            Stat::make($title.'Salary This Month', Expense::whereMonth('date', now()->month)->where('source', 'Salary')->sum('amount')),
        ];
    }
}
