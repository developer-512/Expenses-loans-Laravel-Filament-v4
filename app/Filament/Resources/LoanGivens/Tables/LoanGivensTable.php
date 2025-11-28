<?php

namespace App\Filament\Resources\LoanGivens\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class LoanGivensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                Split::make([
                        TextColumn::make('borrower.name')
                            ->searchable(),
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
                        IconColumn::make('paid')->label('Is Paid?')
                            ->boolean(),
                        TextColumn::make('repayment_date')
                            ->date()
                            ->sortable()->placeholder('Not Paid Yet'),
                        ])
                    ])->columnSpanFull()->from('md'),

                /*Split::make([
//                TextColumn::make('user.name')
//                    ->searchable(),
                TextColumn::make('borrower.name')
                    ->searchable(),
//                TextColumn::make('receipt')
//                    ->searchable(),
                TextColumn::make('amount')
                        ->numeric()
                        ->money('pkr', true)
                        ->sortable(),
                    TextColumn::make('date')
                        ->date()
                        ->sortable(),
                   Stack::make([
                        IconColumn::make('paid')->label('Is Paid?')
                            ->boolean(),
                       TextColumn::make('repayment_date')
                           ->date()
                           ->sortable(),
                    ]),
                ])->from('md'),*/
                Panel::make([
                    Stack::make([
                        TextColumn::make('purpose')
                            ->searchable()->columnSpanFull(),
                    ])
                ])->collapsible(false)
//                TextColumn::make('created_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
//                TextColumn::make('updated_at')
//                    ->dateTime()
//                    ->sortable()
//                    ->toggleable(isToggledHiddenByDefault: true),
            ])->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->filters([
                SelectFilter::make('borrower_id')
                    ->label('Borrower')
                    ->options(
                        User::where('id', '!=', auth()->id())
                            ->pluck('name', 'id')
                    )
                    ->searchable(),
                TernaryFilter::make('paid')
                    ->label('Paid Status')
                    ->trueLabel('Paid')
                    ->falseLabel('Unpaid')
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
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
