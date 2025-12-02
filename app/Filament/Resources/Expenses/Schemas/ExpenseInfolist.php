<?php

namespace App\Filament\Resources\Expenses\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ExpenseInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Expense Details')
                    ->schema([
                        TextEntry::make('title')->label('Title:'),
                        TextEntry::make('amount')->label('Amount:'),
                        TextEntry::make('source')->label('Source:'),
                        TextEntry::make('date')->label('Date:'),
                    ])
                    ->columns(2)->columnSpanFull(),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('description')->label('Details:')
                            ->html(), // allow rich text
                         ImageEntry::make('receipt')->label('Receipt:')->imageWidth(250)->imageHeight('auto'),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
