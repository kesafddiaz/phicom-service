<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionsResource\Pages;
use App\Filament\Resources\TransactionsResource\RelationManagers;
use App\Models\Transactions;
use App\Models\Items;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionsResource extends Resource
{
    protected static ?string $model = Transactions::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('services_id')
                    ->relationship('services', 'services_id')
                    ->required(),
                
                Forms\Components\Select::make('item_id')
                    ->relationship('item', 'name')
                    ->required()
                    ->live() // Membuat field bereaksi secara real-time
                    ->afterStateUpdated(function ($state, callable $set) {
                        // Set harga item saat item dipilih
                        $item = Items::find($state);
                        $set('item_price', $item?->price ?? 0);
                    }),
                
                Forms\Components\TextInput::make('item_price')
                    ->label('Item Price')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(), // Hanya untuk tampilan
                
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->live() // Membuat field bereaksi secara real-time
                    ->afterStateUpdated(function (Get $get, callable $set) {
                        // Hitung subtotal secara otomatis
                        $quantity = $get('quantity') ?? 0;
                        $price = $get('item_price') ?? 0;
                        $set('subtotal', $quantity * $price);
                    }),
                
                Forms\Components\TextInput::make('subtotal')
                    ->label('Subtotal')
                    ->numeric()
                    ->prefix('Rp')
                    ->live() 
                    ->disabled() // Mencegah user mengedit
                    ->dehydrated(), // Memastikan nilai tetap tersimpan
                   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('services.services_id')->searchable(),
                Tables\Columns\TextColumn::make('item.name')->searchable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->sortable(),
                Tables\Columns\TextColumn::make('item.price')
                    ->label('Item Price')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->headerActions([]) // Hapus header actions
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
                
            ]);
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransactions::route('/create'),
            'edit' => Pages\EditTransactions::route('/{record}/edit'),
        ];
    }
}