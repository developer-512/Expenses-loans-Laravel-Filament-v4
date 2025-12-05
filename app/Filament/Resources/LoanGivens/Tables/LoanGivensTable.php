<?php

namespace App\Filament\Resources\LoanGivens\Tables;

use App\Models\User;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class LoanGivensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                Split::make([
                        TextColumn::make('borrower.name')
                            ->searchable(),
                    IconColumn::make('paid')->label('Is Paid?')
                        ->boolean(),
                    Stack::make([
                        TextColumn::make('amount')
                            ->numeric()
                            ->money('pkr', true)
                            ->sortable(),
                        TextColumn::make('date')
                            ->date()
                            ->sortable(),
                        ]),
                    Stack::make([

                        ToggleColumn::make('paid')
                            ->label('Is Received?')
                            ->onColor('success')
                            ->offColor('danger')

                            ->updateStateUsing(function ($record, $state) {
                                // If you need custom logic
                                $record->paid = $state;
                                if($state){
                                    $record->amount_paid = $record->amount;
                                    $record->repayment_date = now()->toDateString();
                                }else{
                                    $record->amount_paid = 0;
                                }
                                $record->save();
                            }),
                        TextColumn::make('repayment_date')
                            ->date()
                            ->sortable()->placeholder('Not Received Yet'),
                        ])
                    ])->columnSpanFull()->from('md'),
                Panel::make([
                    Stack::make([
                        TextColumn::make('purpose')
                            ->searchable()->columnSpanFull(),
                    ])
                ])->collapsible(false)
            ])->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])->recordUrl(null)
            ->filters([
                SelectFilter::make('borrower_id')
                    ->label('Borrower')
                    ->options(
                        User::where('id', '!=', auth()->id())
                            ->pluck('name', 'id')
                    )
                    ->searchable(),
                TernaryFilter::make('paid')
                    ->label('Received Status')
                    ->trueLabel('Received')
                    ->falseLabel('Not Received')
                    ->placeholder('All'),
                Filter::make('date')
                    ->schema([
                        DatePicker::make('created_from'),
                        DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    })
            ])
            ->recordActions([
                ViewAction::make()->button(),
                EditAction::make()->button(),
                DeleteAction::make()->button(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                BulkAction::make('mark_paid')
                    ->label('Mark as Received')
                    ->icon(Heroicon::CheckCircle)
                    ->requiresConfirmation()
                    ->color('success')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $record->paid = true;
                            $record->amount_paid = $record->amount;
                            $record->repayment_date = now()->toDateString();
                            $record->save();
                        }
                    }),
            ]);
    }
}
