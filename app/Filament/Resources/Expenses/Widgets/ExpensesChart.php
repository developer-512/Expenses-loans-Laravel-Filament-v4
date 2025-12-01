<?php

namespace App\Filament\Resources\Expenses\Widgets;

use App\Models\Expense;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class ExpensesChart extends ChartWidget
{
    protected ?string $heading = 'Last 12 Months Expense';
    protected ?string $maxHeight = '500px';
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        $labels = [];
        $currentYearValues = [];
        $previousYearValues = [];

        // Loop 12 months back
        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $labels[] = $month->format('M');

            // Current 12-month range
            $currentTotal = Expense::whereYear('date', $month->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $currentYearValues[] = $currentTotal;

            // Same month but 1 year earlier
            $previousTotal = Expense::whereYear('date', $month->copy()->subYear()->year)
                ->whereMonth('date', $month->month)
                ->sum('amount');

            $previousYearValues[] = $previousTotal;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Last 12 Months',
                    'data' => $currentYearValues,
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
                [
                    'label' => 'Previous 12 Months',
                    'data' => $previousYearValues,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
