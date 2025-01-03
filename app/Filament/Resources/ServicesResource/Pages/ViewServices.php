<?php

namespace App\Filament\Resources\ServicesResource\Pages;

use App\Filament\Resources\ServicesResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;
use Filament\Support\Enums\ActionSize;

class ViewServices extends ViewRecord
{
    protected static string $resource = ServicesResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('print')
                ->label('Print Nota')
                ->color('primary')
                ->icon('heroicon-o-printer')
                ->size(ActionSize::Small)
                ->url(fn () => route('services.print', $this->record)),
        ];
    }
}