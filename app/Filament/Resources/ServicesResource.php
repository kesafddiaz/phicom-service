<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServicesResource\Pages;
use App\Filament\Resources\ServicesResource\RelationManagers;
use App\Models\Services;
use App\Models\Customers;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Support\Enums\MaxWidth;

class ServicesResource extends Resource
{
    protected static ?string $model = Services::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Service Details')
                    ->schema([
                        Forms\Components\TextInput::make('services_id')
                            ->label('Service ID')
                            ->default(function () {
                                // Generate a unique service ID
                                // Format: SRV-YYYYMMDD-XXXX (e.g., SRV-20240612-1234)
                                $prefix = 'PHICOM-' . now()->format('Ymd') . '-';
                                $lastService = Services::where('services_id', 'like', $prefix . '%')
                                    ->orderBy('services_id', 'desc')
                                    ->first();

                                if (!$lastService) {
                                    return $prefix . '0001';
                                }

                                $lastNumber = intval(substr($lastService->services_id, -4));
                                return $prefix . str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
                            })
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->disabled()
                            ->dehydrated(),

                        Forms\Components\Select::make('customer_id')
                            ->label('Customer')
                            ->options(Customers::all()->pluck('name', 'id'))
                            ->required()
                            ->searchable()
                            ->suffixActions([
                                Action::make('create_customer')
                                    ->label('Add New Customer')
                                    ->icon('heroicon-m-plus')
                                    ->color('primary')
                                    ->outlined()
                                    ->action(function ($livewire) {
                                        $livewire->redirect(CustomersResource::getUrl('create'));
                                    })
                            ]),
                        
                        Forms\Components\Textarea::make('device_details')
                            ->label('Device Details')
                            ->required()
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('status')
                            ->label('Service Status')
                            ->options([
                                'MENUNGGU' => 'Menunggu',
                                'SEDANG_DIKERJAKAN' => 'Sedang Dikerjakan',
                                'SELESAI' => 'Perbaikan Selesai',
                                'DIAMBIL' => 'Sudah Diambil'
                            ])
                            ->required(),
                        
                        Forms\Components\TextInput::make('cost_estimate')
                            ->label('Cost Estimate')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('services_id')
                    ->label('Service ID')
                    ->searchable(),

                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('device_details')
                    ->label('Device Details')
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'MENUNGGU' => 'warning',
                        'SEDANG_DIKERJAKAN' => 'primary',
                        'SELESAI' => 'success',
                        'DIAMBIL' => 'gray',
                    }),
                
                Tables\Columns\TextColumn::make('cost_estimate')
                    ->label('Cost Estimate')
                    ->money('idr')
            ])
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
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
        ];
    }
}