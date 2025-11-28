<?php

namespace App\Filament\Resources\LoanTakens\Tables;

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

class LoanTakensTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                TextColumn::make('lender.name')
                    ->searchable(),
                Stack::make([
                TextColumn::make('amount')
                    ->numeric()->money('pkr',true)
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
                Panel::make([
                    Stack::make([
                        TextColumn::make('purpose')
                            ->searchable()->columnSpanFull(),
                    ])
                ])->collapsible(false)
            ])->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->filters([
                SelectFilter::make('lender_id')
                    ->label('Lender')
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
