<?php

namespace App\Filament\Resources\LoanTakens\Schemas;

use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanTakenInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Loan Details')
                    ->schema([
                        TextEntry::make('lender.name')
                            ->label('Loan Giver:'),
                        TextEntry::make('amount')->label('Amount:')->money('pkr',true),
                        TextEntry::make('date')->label('Date:'),
                        IconEntry::make('paid')
                            ->boolean(),
                        TextEntry::make('repayment_date')->label('Repayment Date:')
                            ->date()
                            ->placeholder('Not Paid Yet'),
                        TextEntry::make('amount_paid')->label('Amount Paid:')->money('pkr',true),
//                        TextEntry::make('updated_at')
//                            ->dateTime()
//                            ->placeholder('-'),
                    ])
                    ->columns(2)->columnSpanFull(),

                Section::make('Description')
                    ->schema([
                        TextEntry::make('purpose')->label('Loan Purpose Details')
                            ->html(), // allow rich text
                        ImageEntry::make('receipt')->label('Receipt:')->imageWidth(250)->imageHeight('auto'),
                    ])->columns(2)->columnSpanFull(),
            ]);
    }
}
