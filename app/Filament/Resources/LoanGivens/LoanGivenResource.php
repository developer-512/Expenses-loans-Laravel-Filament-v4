<?php

namespace App\Filament\Resources\LoanGivens;

use App\Filament\Resources\LoanGivens\Pages\CreateLoanGiven;
use App\Filament\Resources\LoanGivens\Pages\EditLoanGiven;
use App\Filament\Resources\LoanGivens\Pages\ListLoanGivens;
use App\Filament\Resources\LoanGivens\Pages\ViewLoanGiven;
use App\Filament\Resources\LoanGivens\Schemas\LoanGivenForm;
use App\Filament\Resources\LoanGivens\Schemas\LoanGivenInfolist;
use App\Filament\Resources\LoanGivens\Tables\LoanGivensTable;
use App\Models\LoanGiven;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanGivenResource extends Resource
{
    protected static ?string $model = LoanGiven::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Loans I Gave';
    protected static ?string $label = 'Loans I Gave';

    public static function form(Schema $schema): Schema
    {
        return LoanGivenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoanGivenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanGivensTable::configure($table);
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
            'index' => ListLoanGivens::route('/'),
            'create' => CreateLoanGiven::route('/create'),
            'view' => ViewLoanGiven::route('/{record}'),
            'edit' => EditLoanGiven::route('/{record}/edit'),
        ];
    }
    protected static ?string $navigationLabel = 'Loans I Gave';
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }
}
