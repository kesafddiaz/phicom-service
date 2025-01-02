<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicesResource\Pages;
use App\Models\Services;
use App\Models\Customers;
use App\Models\Items;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Illuminate\Support\Str;

class ServicesResource extends Resource
{
    protected static ?string $model = Services::class;
    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $modelLabel = 'Service';
    protected static ?string $pluralModelLabel = 'Services';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Details')
                    ->schema([
                        Forms\Components\TextInput::make('services_id')
                            ->label('Service ID')
                            ->default(fn () => static::generateServiceId())
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->relationship('customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->maxLength(255),
                            ]),
                        
                        Forms\Components\Textarea::make('service_details')
                            ->label('Service Details')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('status')
                            ->label('Service Status')
                            ->options([
                                'MENUNGGU' => 'Menunggu',
                                'SEDANG_DIKERJAKAN' => 'Sedang Dikerjakan',
                                'SELESAI' => 'Perbaikan Selesai',
                                'DIAMBIL' => 'Sudah Diambil'
                            ])
                            ->required()
                            ->default('MENUNGGU'),
                    ])
                    ->columns(2),

                    Forms\Components\Section::make('Parts and Items')
                    ->schema([
                        Forms\Components\Repeater::make('transactions')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('item_id')
                                    ->label('Item')
                                    ->relationship('item', 'name')
                                    ->required()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        if (!$state) {
                                            $set('price', 0);
                                            $set('subtotal', 0);
                                            return;
                                        }
                                        
                                        $item = Items::find($state);
                                        if (!$item) {
                                            $set('price', 0);
                                            $set('subtotal', 0);
                                            return;
                                        }

                                        $quantity = (int) ($get('quantity') ?: 1);
                                        $price = (float) $item->price;
                                        
                                        $set('price', $price); // Ubah dari item_price ke price
                                        $set('subtotal', $price * $quantity);
                                    }),

                                Forms\Components\TextInput::make('price') // Ubah dari item_price ke price
                                    ->label('Price')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(),

                                Forms\Components\TextInput::make('quantity')
                                    ->label('Quantity')
                                    ->numeric()
                                    ->default(1)
                                    ->minValue(1)
                                    ->required()
                                    ->live()
                                    ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                        $price = (float) ($get('price') ?: 0); // Ubah dari item_price ke price
                                        $quantity = (int) ($state ?: 1);
                                        $set('subtotal', $price * $quantity);
                                    }),
                
                                // Forms\Components\TextInput::make('item_price')
                                //     ->label('Price')
                                //     ->numeric()
                                //     ->prefix('Rp')
                                //     ->disabled()
                                //     ->dehydrated(),
                
                                // Forms\Components\TextInput::make('quantity')
                                //     ->label('Quantity')
                                //     ->numeric()
                                //     ->default(1)
                                //     ->minValue(1)
                                //     ->required()
                                //     ->live()
                                //     ->afterStateUpdated(function (Get $get, Set $set, $state) {
                                //         $price = (float) ($get('item_price') ?: 0);
                                //         $quantity = (int) ($state ?: 1);
                                //         $set('subtotal', $price * $quantity);
                                //     }),
                
                                Forms\Components\TextInput::make('subtotal')
                                    ->label('Subtotal')
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->disabled()
                                    ->dehydrated(),

                                // Hidden field to store services_id
                                Forms\Components\Hidden::make('services_id')
                                    ->default(fn (Get $get) => $get('services_id')),
                            ])
                            ->columns(4)
                            ->defaultItems(0)
                            ->reorderable(false)
                            ->collapsible()
                            ->live()
                            ->afterStateUpdated(function (Get $get, Set $set) {
                                $transactions = $get('transactions') ?: [];
                                $total = collect($transactions)
                                    ->sum(function ($transaction) {
                                        $quantity = (int) ($transaction['quantity'] ?? 1);
                                        $price = (float) ($transaction['price'] ?? 0); // Ubah dari item_price ke price
                                        return $quantity * $price;
                                    });
                                
                                $set('total', $total);
                            }),
                
                        Forms\Components\TextInput::make('total')
                            ->label('Total Cost')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated()
                            ->default(0),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('services_id')
                    ->label('Service ID')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('service_details')
                    ->label('Device Details')
                    ->words(10)
                    ->tooltip(fn (Tables\Columns\TextColumn $column): string => $column->getState()),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'MENUNGGU' => 'warning',
                        'SEDANG_DIKERJAKAN' => 'info',
                        'SELESAI' => 'success',
                        'DIAMBIL' => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('total')
                    ->label('Total Cost')
                    ->money('idr')
                    ->sortable(),

                Tables\Columns\TextColumn::make('transactions_count')
                    ->label('Items')
                    ->counts('transactions')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'MENUNGGU' => 'Menunggu',
                        'SEDANG_DIKERJAKAN' => 'Sedang Dikerjakan',
                        'SELESAI' => 'Perbaikan Selesai',
                        'DIAMBIL' => 'Sudah Diambil'
                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateServices::route('/create'),
            'edit' => Pages\EditServices::route('/{record}/edit'),
            'view' => Pages\ViewServices::route('/{record}'), // Tambahkan ini
        ];
    }

    private static function generateServiceId(): string
    {
        $prefix = 'PHICOM-' . now()->format('Ymd') . '-';
        $lastService = Services::where('services_id', 'like', $prefix . '%')
            ->orderBy('services_id', 'desc')
            ->first();

        if (!$lastService) {
            return $prefix . '0001';
        }

        $lastNumber = intval(substr($lastService->services_id, -4));
        return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    }
}