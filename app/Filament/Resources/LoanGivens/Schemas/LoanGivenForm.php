<?php

namespace App\Filament\Resources\LoanGivens\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class LoanGivenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Loan Details:')->schema([
                    Select::make('borrower_id')->label('Loan Borrower')
                        ->relationship('borrower', 'name', fn ($query) =>
                        $query->where('id', '!=', auth()->id())
                        )
                        ->searchable()
                        ->preload()
                        ->required(),
                    TextInput::make('amount')
                        ->label('Loan Amount:')
                        ->required()
                        ->numeric()
                        ->default(0),


                    DatePicker::make('date')
                        ->label('Loan Issue Date:')
                        ->displayFormat('d/m/Y')
                        ->format('Y-m-d')
                        ->required()
                        ->native(false)
                        ->default(now()),

                    Textarea::make('purpose')->label('Purpose:')->columnSpanFull()->rows(3),
                ])->columns(3)->columnSpanFull(),
                Section::make('Loan Proof/Receipt Details:')->schema([
                FileUpload::make('receipt')
                    ->label('Receipt')
                    ->disk('public')
                    ->directory('receipts')
                    ->visibility('public')
                    ->maxSize(10240) // 10MB
                    ->nullable(),
                    ]),
                Section::make('Loan Repayment Details:')->schema([

                Toggle::make('paid')->label('Is Loan Already Paid?:')
                    ->default(false),
                    DatePicker::make('repayment_date')
                        ->label('Loan Repayment Date:')
                        ->displayFormat('d/m/Y')
                        ->format('Y-m-d')
                        ->native(false),
                    TextInput::make('amount_paid')
                        ->label('Loan Amount Paid:')
                        ->numeric()
                        ->default(''),
                    ])

            ]);
    }
}
