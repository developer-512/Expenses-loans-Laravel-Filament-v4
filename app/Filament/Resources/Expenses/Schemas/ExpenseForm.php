<?php

namespace App\Filament\Resources\Expenses\Schemas;

use App\Models\Expense;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExpenseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')->label('Title')
                    ->maxLength(255)->columnSpanFull(),
                RichEditor::make('description')->label('Description')
                    ->maxLength(500)->columnSpanFull()->extraAttributes([
                        'style' => 'min-height: 300px; height: 300px;',
                    ]),
                TextInput::make('amount')
                    ->label('Amount')
                    ->numeric()
                    ->required(),
                FileUpload::make('receipt')
                    ->label('Receipt')
                    ->disk('public')
                    ->directory('receipts')
                    ->visibility('public')
                    ->maxSize(10240) // 10MB
                    ->nullable(),
                Select::make('source')
                    ->label('Source')
                    ->options(array_combine(
                        Expense::SOURCE_TYPES,
                        Expense::SOURCE_TYPES
                    ))
                    ->required()
                    ->searchable()
                    ->default('Salary')
                    ->loadingMessage('Loading Sources...')
                    ->native(false),
                DatePicker::make('date')
                    ->label('Expense Date')
                    ->displayFormat('d/m/Y')
                    ->format('Y-m-d')
                    ->required()
                    ->native(false)
                    ->default(now()),
                Hidden::make('user_id')->default(auth()->id()),


            ]);
    }
}
