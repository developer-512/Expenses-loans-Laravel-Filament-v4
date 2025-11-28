<?php

namespace App\Filament\Resources\LoanTakens;

use App\Filament\Resources\LoanTakens\Pages\CreateLoanTaken;
use App\Filament\Resources\LoanTakens\Pages\EditLoanTaken;
use App\Filament\Resources\LoanTakens\Pages\ListLoanTakens;
use App\Filament\Resources\LoanTakens\Pages\ViewLoanTaken;
use App\Filament\Resources\LoanTakens\Schemas\LoanTakenForm;
use App\Filament\Resources\LoanTakens\Schemas\LoanTakenInfolist;
use App\Filament\Resources\LoanTakens\Tables\LoanTakensTable;
use App\Models\LoanTaken;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class LoanTakenResource extends Resource
{
    protected static ?string $model = LoanTaken::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Loans I Took';
    protected static ?string $label = 'Loans I Took';

    public static function form(Schema $schema): Schema
    {
        return LoanTakenForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return LoanTakenInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LoanTakensTable::configure($table);
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
            'index' => ListLoanTakens::route('/'),
            'create' => CreateLoanTaken::route('/create'),
            'view' => ViewLoanTaken::route('/{record}'),
            'edit' => EditLoanTaken::route('/{record}/edit'),
        ];
    }
    protected static ?string $navigationLabel = 'Loans I Took';
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }
}
