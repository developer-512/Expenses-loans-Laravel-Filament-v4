<?php

namespace App\Filament\Resources\Expenses;

use App\Filament\Resources\Expenses\Pages\CreateExpense;
use App\Filament\Resources\Expenses\Pages\EditExpense;
use App\Filament\Resources\Expenses\Pages\ListExpenses;
use App\Filament\Resources\Expenses\Pages\ViewExpense;
use App\Filament\Resources\Expenses\Schemas\ExpenseForm;
use App\Filament\Resources\Expenses\Schemas\ExpenseInfolist;
use App\Filament\Resources\Expenses\Tables\ExpensesTable;
use App\Models\Expense;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ExpenseForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ExpenseInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ExpensesTable::configure($table)->defaultSort('id', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListExpenses::route('/'),
            'create' => CreateExpense::route('/create'),
            'view' => ViewExpense::route('/{record}'),
            'edit' => EditExpense::route('/{record}/edit'),
        ];
    }
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }
    public static function getGloballySearchableAttributes(): array
    {
        return ['title', 'amount', 'source', 'description','date'];
    }
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        return [
            'Title' => $record->title,
            'Amount' => $record->amount,
            'Date' => $record->date,
        ];
    }
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('edit')
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }
}
